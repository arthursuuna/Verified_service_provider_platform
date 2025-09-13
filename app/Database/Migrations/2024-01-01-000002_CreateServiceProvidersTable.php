<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServiceProvidersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'business_name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
            ],
            'owner_name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 190,
                'null' => false,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'Verified', 'Suspended'],
                'default' => 'Pending',
                'null' => false,
            ],
            'is_subscribed' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email', 'uq_provider_email');
        $this->forge->addKey('status', false, false, 'ix_status');
        $this->forge->addKey('is_subscribed', false, false, 'ix_is_subscribed');
        $this->forge->createTable('service_providers');

        // Set timestamp defaults with raw SQL
        $this->db->query('ALTER TABLE service_providers MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->db->query('ALTER TABLE service_providers MODIFY updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->forge->dropTable('service_providers');
    }
}
