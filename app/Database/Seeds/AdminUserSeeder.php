<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Admin User',
            'email' => 'admin@blb.ug',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'type' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Check if admin user already exists
        $existing = $this->db->table('users')->where('email', 'admin@blb.ug')->get()->getRow();

        if (!$existing) {
            $this->db->table('users')->insert($data);
            echo "Admin user created: admin@blb.ug / admin123\n";
        } else {
            echo "Admin user already exists: admin@blb.ug\n";
        }
    }
}
