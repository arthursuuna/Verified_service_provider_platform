<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * User dashboard
     */
    public function dashboard()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        // Get user's service requests
        $db = \Config\Database::connect();

        try {
            $requests = $db->table('service_requests sr')
                ->select('sr.*, sp.business_name, sp.owner_name, sp.phone, "General Service" as service_type')
                ->join('service_providers sp', 'sp.id = sr.service_provider_id')
                ->where('sr.user_id', $userId)
                ->orderBy('sr.created_at', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            // Get request statistics with error handling
            $stats = [
                'total_requests' => $db->table('service_requests')->where('user_id', $userId)->countAllResults(),
                'active_requests' => $db->table('service_requests')->where('user_id', $userId)->whereIn('status', ['New', 'Contacted'])->countAllResults(),
                'completed_requests' => $db->table('service_requests')->where('user_id', $userId)->where('status', 'Completed')->countAllResults(),
                'providers_contacted' => $db->table('service_requests')->select('service_provider_id')->where('user_id', $userId)->distinct()->countAllResults(),
            ];
        } catch (\Exception $e) {
            // If database query fails, provide default values
            $requests = [];
            $stats = [
                'total_requests' => 0,
                'active_requests' => 0,
                'completed_requests' => 0,
                'providers_contacted' => 0,
            ];

            // Log the error (optional)
            log_message('error', 'Dashboard data fetch failed: ' . $e->getMessage());
        }

        $data = [
            'title' => 'User Dashboard - BLB',
            'user' => $user,
            'recentRequests' => $requests,
            'stats' => $stats
        ];

        return view('user/dashboard', $data);
    }

    /**
     * User profile
     */
    public function profile()
    {
        $userId = $this->session->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'My Profile - BLB',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        return view('user/profile', $data);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        $userId = $this->session->get('user_id');

        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'email' => "required|valid_email|max_length[190]|is_unique[users.email,id,{$userId}]",
            'phone' => 'permit_empty|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->profile();
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        if ($this->userModel->updateProfile($userId, $updateData)) {
            // Update session data
            $this->session->set([
                'user_name' => $updateData['name'],
                'user_email' => $updateData['email']
            ]);

            $this->session->setFlashdata('success', 'Profile updated successfully!');
        } else {
            $this->session->setFlashdata('error', 'Failed to update profile. Please try again.');
        }

        return redirect()->to('/user/profile');
    }

    /**
     * User's service requests
     */
    public function requests()
    {
        $userId = $this->session->get('user_id');

        $db = \Config\Database::connect();
        $requests = $db->table('service_requests sr')
            ->select('sr.*, sp.business_name, sp.owner_name, sp.phone, sp.email as provider_email')
            ->join('service_providers sp', 'sp.id = sr.service_provider_id')
            ->where('sr.user_id', $userId)
            ->orderBy('sr.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'My Service Requests - BLB',
            'requests' => $requests
        ];

        return view('user/requests', $data);
    }

    /**
     * View specific service request
     */
    public function viewRequest($requestId)
    {
        $userId = $this->session->get('user_id');

        $db = \Config\Database::connect();
        $request = $db->table('service_requests sr')
            ->select('sr.*, sp.business_name, sp.owner_name, sp.phone, sp.email as provider_email, sp.location, sp.description as provider_description')
            ->join('service_providers sp', 'sp.id = sr.service_provider_id')
            ->where('sr.id', $requestId)
            ->where('sr.user_id', $userId)
            ->get()
            ->getRowArray();

        if (!$request) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Service request not found');
        }

        $data = [
            'title' => 'Service Request Details - BLB',
            'request' => $request
        ];

        return view('user/view_request', $data);
    }
}
