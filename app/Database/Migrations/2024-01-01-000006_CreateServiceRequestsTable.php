<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServiceRequestsTable extends Migration
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
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'service_provider_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'requested_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['New', 'Contacted', 'Completed', 'Cancelled'],
                'default' => 'New',
                'null' => false,
            ],
            'admin_notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('user_id', false, false, 'ix_req_user');
        $this->forge->addKey('service_provider_id', false, false, 'ix_req_provider');
        $this->forge->addKey('status', false, false, 'ix_req_status');
        $this->forge->createTable('service_requests');

        // Set timestamp defaults and requested_at default
        $this->db->query('ALTER TABLE service_requests MODIFY requested_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->db->query('ALTER TABLE service_requests MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->db->query('ALTER TABLE service_requests MODIFY updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        // Add foreign key constraints
        $this->db->query('ALTER TABLE service_requests 
                         ADD CONSTRAINT fk_req_user 
                         FOREIGN KEY (user_id) REFERENCES users(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');

        $this->db->query('ALTER TABLE service_requests 
                         ADD CONSTRAINT fk_req_provider 
                         FOREIGN KEY (service_provider_id) REFERENCES service_providers(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('service_requests');
    }
}
