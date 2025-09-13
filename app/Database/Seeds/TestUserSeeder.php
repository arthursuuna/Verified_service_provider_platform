<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@email.com',
                'phone' => '+256700123456',
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
                'type' => 'regular',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@email.com',
                'phone' => '+256700654321',
                'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
                'type' => 'regular',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($users as $user) {
            // Check if user already exists
            $existing = $this->db->table('users')->where('email', $user['email'])->get()->getRow();

            if (!$existing) {
                $this->db->table('users')->insert($user);
                echo "User created: {$user['email']} / user123\n";
            } else {
                echo "User already exists: {$user['email']}\n";
            }
        }
    }
}
