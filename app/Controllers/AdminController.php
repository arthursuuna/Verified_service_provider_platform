<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        $db = \Config\Database::connect();

        // Get statistics
        $stats = [
            'providers' => [
                'total' => $db->table('service_providers')->countAllResults(),
                'verified' => $db->table('service_providers')->where('status', 'Verified')->countAllResults(),
                'pending' => $db->table('service_providers')->where('status', 'Pending')->countAllResults(),
                'suspended' => $db->table('service_providers')->where('status', 'Suspended')->countAllResults(),
            ],
            'users' => $this->userModel->getStats(),
            'requests' => [
                'total' => $db->table('service_requests')->countAllResults(),
                'new' => $db->table('service_requests')->where('status', 'New')->countAllResults(),
                'contacted' => $db->table('service_requests')->where('status', 'Contacted')->countAllResults(),
                'completed' => $db->table('service_requests')->where('status', 'Completed')->countAllResults(),
            ]
        ];

        // Recent activities
        $recentProviders = $db->table('service_providers')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $recentRequests = $db->table('service_requests sr')
            ->select('sr.*, sp.business_name, u.name as user_name')
            ->join('service_providers sp', 'sp.id = sr.service_provider_id')
            ->join('users u', 'u.id = sr.user_id')
            ->orderBy('sr.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Admin Dashboard - BLB',
            'stats' => $stats,
            'recentProviders' => $recentProviders,
            'recentRequests' => $recentRequests
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Manage service providers
     */
    public function providers()
    {
        $db = \Config\Database::connect();

        $providers = $db->table('service_providers sp')
            ->select('sp.*, GROUP_CONCAT(sc.name) as categories')
            ->join('provider_service_categories psc', 'psc.provider_id = sp.id', 'left')
            ->join('service_categories sc', 'sc.id = psc.category_id', 'left')
            ->groupBy('sp.id')
            ->orderBy('sp.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Manage Providers - BLB',
            'providers' => $providers
        ];

        return view('admin/providers', $data);
    }

    /**
     * View specific provider
     */
    public function viewProvider($providerId)
    {
        $db = \Config\Database::connect();

        $provider = $db->table('service_providers sp')
            ->select('sp.*, GROUP_CONCAT(sc.name) as categories')
            ->join('provider_service_categories psc', 'psc.provider_id = sp.id', 'left')
            ->join('service_categories sc', 'sc.id = psc.category_id', 'left')
            ->where('sp.id', $providerId)
            ->groupBy('sp.id')
            ->get()
            ->getRowArray();

        if (!$provider) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Provider not found');
        }

        // Get provider's requests
        $requests = $db->table('service_requests sr')
            ->select('sr.*, u.name as user_name, u.email as user_email')
            ->join('users u', 'u.id = sr.user_id')
            ->where('sr.service_provider_id', $providerId)
            ->orderBy('sr.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Provider Details - BLB',
            'provider' => $provider,
            'requests' => $requests
        ];

        return view('admin/view_provider', $data);
    }

    /**
     * Verify provider
     */
    public function verifyProvider($providerId)
    {
        $db = \Config\Database::connect();

        $updated = $db->table('service_providers')
            ->where('id', $providerId)
            ->update(['status' => 'Verified']);

        if ($updated) {
            $this->session->setFlashdata('success', 'Provider verified successfully!');
        } else {
            $this->session->setFlashdata('error', 'Failed to verify provider.');
        }

        return redirect()->to('/admin/provider/' . $providerId);
    }

    /**
     * Suspend provider
     */
    public function suspendProvider($providerId)
    {
        $db = \Config\Database::connect();

        $updated = $db->table('service_providers')
            ->where('id', $providerId)
            ->update(['status' => 'Suspended']);

        if ($updated) {
            $this->session->setFlashdata('success', 'Provider suspended successfully!');
        } else {
            $this->session->setFlashdata('error', 'Failed to suspend provider.');
        }

        return redirect()->to('/admin/provider/' . $providerId);
    }

    /**
     * Manage users
     */
    public function users()
    {
        $users = $this->userModel->select('id, name, email, phone, type, created_at')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Manage Users - BLB',
            'users' => $users
        ];

        return view('admin/users', $data);
    }

    /**
     * Manage service requests
     */
    public function requests()
    {
        $db = \Config\Database::connect();

        $requests = $db->table('service_requests sr')
            ->select('sr.*, sp.business_name, u.name as user_name, u.email as user_email')
            ->join('service_providers sp', 'sp.id = sr.service_provider_id')
            ->join('users u', 'u.id = sr.user_id')
            ->orderBy('sr.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Manage Requests - BLB',
            'requests' => $requests
        ];

        return view('admin/requests', $data);
    }
}
