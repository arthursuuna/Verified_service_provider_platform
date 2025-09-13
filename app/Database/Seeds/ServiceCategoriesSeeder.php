<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Plumbing',
                'slug' => 'plumbing',
                'is_active' => true,
            ],
            [
                'name' => 'Surveying',
                'slug' => 'surveying',
                'is_active' => true,
            ],
            [
                'name' => 'Construction',
                'slug' => 'construction',
                'is_active' => true,
            ],
            [
                'name' => 'Farming',
                'slug' => 'farming',
                'is_active' => true,
            ],
        ];

        // Using the query builder to insert data
        $this->db->table('service_categories')->insertBatch($data);
    }
}
