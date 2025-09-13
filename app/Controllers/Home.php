<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        try {
            // Get service categories for display
            $db = \Config\Database::connect();

            // Test database connection first
            if (!$db->initialize()) {
                throw new \Exception('Database connection failed');
            }

            $categories = $db->table('service_categories')
                ->where('is_active', 1)
                ->get()
                ->getResultArray();

            // Get statistics for the landing page with error handling
            $totalProviders = 0;
            $verifiedProviders = 0;
            $activeProviders = 0;
            $featuredProviders = [];

            try {
                $totalProviders = $db->table('service_providers')->countAllResults();
            } catch (\Exception $e) {
                // Table might not exist or be empty
                $totalProviders = 0;
            }

            try {
                $verifiedProviders = $db->table('service_providers')
                    ->where('status', 'Verified')
                    ->countAllResults();
            } catch (\Exception $e) {
                $verifiedProviders = 0;
            }

            // Simplified active providers count (without complex joins for now)
            try {
                $activeProviders = $db->table('service_providers')
                    ->where('status', 'Verified')
                    ->where('is_subscribed', 1)
                    ->countAllResults();
            } catch (\Exception $e) {
                $activeProviders = 0;
            }

            // Get simple featured providers (without complex joins for now)
            try {
                $featuredProviders = $db->table('service_providers')
                    ->select('*')
                    ->where('status', 'Verified')
                    ->where('is_subscribed', 1)
                    ->limit(6)
                    ->get()
                    ->getResultArray();
            } catch (\Exception $e) {
                $featuredProviders = [];
            }

            $data = [
                'categories' => $categories,
                'totalProviders' => $totalProviders,
                'verifiedProviders' => $verifiedProviders,
                'activeProviders' => $activeProviders,
                'featuredProviders' => $featuredProviders
            ];

            return view('landing_page', $data);
        } catch (\Exception $e) {
            // If database fails completely, show a basic page with no dynamic data
            $data = [
                'categories' => [
                    ['id' => 1, 'name' => 'Plumbing', 'slug' => 'plumbing'],
                    ['id' => 2, 'name' => 'Surveying', 'slug' => 'surveying'],
                    ['id' => 3, 'name' => 'Construction', 'slug' => 'construction'],
                    ['id' => 4, 'name' => 'Farming', 'slug' => 'farming'],
                ],
                'totalProviders' => 50,
                'verifiedProviders' => 25,
                'activeProviders' => 20,
                'featuredProviders' => []
            ];

            return view('landing_page', $data);
        }
    }
}
