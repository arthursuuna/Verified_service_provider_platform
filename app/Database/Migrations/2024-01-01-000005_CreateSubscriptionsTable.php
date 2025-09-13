<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptionsTable extends Migration
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
            'service_provider_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Expired', 'GracePeriod'],
                'default' => 'Active',
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
        $this->forge->addKey('service_provider_id', false, false, 'ix_sub_provider');
        $this->forge->addKey('status', false, false, 'ix_sub_status');
        $this->forge->addKey(['start_date', 'end_date'], false, false, 'ix_sub_dates');
        $this->forge->createTable('subscriptions');

        // Set timestamp defaults with raw SQL
        $this->db->query('ALTER TABLE subscriptions MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->db->query('ALTER TABLE subscriptions MODIFY updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        // Add foreign key constraint
        $this->db->query('ALTER TABLE subscriptions 
                         ADD CONSTRAINT fk_sub_provider 
                         FOREIGN KEY (service_provider_id) REFERENCES service_providers(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('subscriptions');
    }
}
