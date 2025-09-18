<?php

namespace App\Controllers;

use App\Models\ServiceProviderModel;
use App\Models\ServiceCategoryModel;

class ServiceProviderController extends BaseController
{
    protected $serviceProviderModel;
    protected $serviceCategoryModel;
    protected $session;

    public function __construct()
    {
        $this->serviceProviderModel = new ServiceProviderModel();
        $this->serviceCategoryModel = new ServiceCategoryModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Show provider registration form
     */
    public function register()
    {
        // Get service categories for the form
        $serviceCategories = [];
        try {
            $serviceCategories = $this->serviceCategoryModel->getActiveCategories();
        } catch (\Exception $e) {
            // If categories table doesn't exist, use specified categories only
            $serviceCategories = [
                ['id' => 1, 'name' => 'Plumbing'],
                ['id' => 2, 'name' => 'Surveying'],
                ['id' => 3, 'name' => 'Construction'],
                ['id' => 4, 'name' => 'Farming']
            ];
        }

        $data = [
            'title' => 'Service Provider Registration - BLB',
            'serviceCategories' => $serviceCategories,
            'validation' => \Config\Services::validation()
        ];

        return view('providers/register_enhanced', $data);
    }

    /**
     * Process provider registration
     */
    public function processRegistration()
    {
        // Enhanced validation rules
        $rules = [
            'business_name' => 'required|min_length[3]|max_length[150]',
            'owner_name' => 'required|min_length[2]|max_length[150]',
            'email' => 'required|valid_email|is_unique[service_providers.email]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'location' => 'required|min_length[3]|max_length[200]',
            'service_description' => 'required|min_length[20]|max_length[2000]',
            'website' => 'permit_empty|valid_url|max_length[255]',
            'categories' => 'required',
            'verification_documents' => 'permit_empty'
        ];

        $messages = [
            'business_name' => [
                'required' => 'Business name is required.',
                'min_length' => 'Business name must be at least 3 characters long.',
                'max_length' => 'Business name cannot exceed 150 characters.'
            ],
            'owner_name' => [
                'required' => 'Owner name is required.',
                'min_length' => 'Owner name must be at least 2 characters long.',
                'max_length' => 'Owner name cannot exceed 150 characters.'
            ],
            'email' => [
                'required' => 'Email address is required.',
                'valid_email' => 'Please enter a valid email address.',
                'is_unique' => 'This email is already registered. Please use a different email.'
            ],
            'phone' => [
                'required' => 'Phone number is required.',
                'min_length' => 'Phone number must be at least 10 characters long.'
            ],
            'location' => [
                'required' => 'Location is required.',
                'min_length' => 'Location must be at least 3 characters long.'
            ],
            'service_description' => [
                'required' => 'Service description is required.',
                'min_length' => 'Service description must be at least 20 characters long.',
                'max_length' => 'Service description cannot exceed 2000 characters.'
            ],
            'categories' => [
                'required' => 'Please select at least one service category.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Handle file uploads
        $uploadedDocuments = [];
        $uploadPath = WRITEPATH . 'uploads/provider_documents/';

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = $this->request->getFiles();
        if (isset($files['verification_documents'])) {
            foreach ($files['verification_documents'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Generate unique filename
                    $newName = uniqid() . '_' . $file->getClientName();
                    $file->move($uploadPath, $newName);
                    $uploadedDocuments[] = $newName;
                }
            }
        }

        // Prepare provider data with enhanced fields
        $providerData = [
            'business_name' => $this->request->getPost('business_name'),
            'owner_name' => $this->request->getPost('owner_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'location' => $this->request->getPost('location'),
            'service_description' => $this->request->getPost('service_description'),
            'website' => $this->request->getPost('website'),
            'verification_documents' => !empty($uploadedDocuments) ? json_encode($uploadedDocuments) : null,
            'status' => 'Pending Verification',
            'is_subscribed' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $categories = $this->request->getPost('categories');

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert provider
            $providerId = $this->serviceProviderModel->insert($providerData);

            if (!$providerId) {
                throw new \Exception('Failed to create service provider record.');
            }

            // Insert provider-category relationships
            if (is_array($categories) && !empty($categories)) {
                $categoryData = [];
                foreach ($categories as $categoryId) {
                    $categoryData[] = [
                        'service_provider_id' => $providerId,
                        'service_category_id' => (int)$categoryId,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }

                // Try to insert categories, but don't fail if table doesn't exist
                try {
                    $db->table('provider_service_categories')->insertBatch($categoryData);
                } catch (\Exception $e) {
                    // Log the error but continue with registration
                    log_message('error', 'Failed to insert provider categories: ' . $e->getMessage());
                }
            }

            // Complete transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed.');
            }

            $this->session->setFlashdata('success', 'Registration successful! Your application is pending admin approval. You will be notified once verified.');
            return redirect()->to('/providers/registration-success?id=' . $providerId);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Provider registration failed: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'Registration failed. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show registration success page
     */
    public function registrationSuccess()
    {
        $providerId = $this->request->getGet('id');
        $provider = null;

        if ($providerId) {
            try {
                $provider = $this->serviceProviderModel->find($providerId);
            } catch (\Exception $e) {
                // Provider not found, continue with generic success page
            }
        }

        $data = [
            'title' => 'Registration Successful - BLB',
            'registrationId' => $providerId,
            'businessName' => $provider['business_name'] ?? 'N/A',
            'ownerName' => $provider['owner_name'] ?? 'N/A',
            'email' => $provider['email'] ?? 'N/A',
            'phone' => $provider['phone'] ?? 'N/A',
            'location' => $provider['location'] ?? 'N/A'
        ];

        return view('providers/registration_success', $data);
    }

    /**
     * List all verified providers (public)
     */
    public function index()
    {
        $db = \Config\Database::connect();

        try {
            $providers = $db->table('service_providers sp')
                ->select('sp.*, GROUP_CONCAT(sc.name) as categories')
                ->join('provider_service_categories psc', 'psc.service_provider_id = sp.id', 'left')
                ->join('service_categories sc', 'sc.id = psc.service_category_id', 'left')
                ->where('sp.status', 'Verified')
                ->groupBy('sp.id')
                ->orderBy('sp.business_name', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Exception $e) {
            $providers = [];
        }

        $data = [
            'title' => 'Verified Service Providers - BLB',
            'providers' => $providers
        ];

        return view('providers/index', $data);
    }

    /**
     * View specific provider details
     */
    public function view($providerId)
    {
        $db = \Config\Database::connect();

        try {
            $provider = $db->table('service_providers sp')
                ->select('sp.*, GROUP_CONCAT(sc.name) as categories')
                ->join('provider_service_categories psc', 'psc.service_provider_id = sp.id', 'left')
                ->join('service_categories sc', 'sc.id = psc.service_category_id', 'left')
                ->where('sp.id', $providerId)
                ->where('sp.status', 'Verified')
                ->groupBy('sp.id')
                ->get()
                ->getRowArray();
        } catch (\Exception $e) {
            $provider = null;
        }

        if (!$provider) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Provider not found or not verified');
        }

        $data = [
            'title' => $provider['business_name'] . ' - BLB',
            'provider' => $provider
        ];

        return view('providers/view', $data);
    }

    /**
     * Show providers by category
     */
    public function category($categorySlug)
    {
        $db = \Config\Database::connect();

        try {
            // Get category by slug
            $category = $this->serviceCategoryModel->getCategoryBySlug($categorySlug);

            if (!$category) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Category not found');
            }

            // Get providers in this category
            $providers = $db->table('service_providers sp')
                ->select('sp.*')
                ->join('provider_service_categories psc', 'psc.service_provider_id = sp.id')
                ->join('service_categories sc', 'sc.id = psc.service_category_id')
                ->where('sc.id', $category['id'])
                ->where('sp.status', 'Verified')
                ->orderBy('sp.business_name', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Exception $e) {
            $providers = [];
            $category = ['name' => ucwords(str_replace('-', ' ', $categorySlug))];
        }

        $data = [
            'title' => $category['name'] . ' Providers - BLB',
            'category' => $category,
            'providers' => $providers
        ];

        return view('providers/category', $data);
    }
}
