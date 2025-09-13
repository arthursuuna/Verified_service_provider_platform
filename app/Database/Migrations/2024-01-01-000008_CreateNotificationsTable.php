<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
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
            'recipient_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['NewServiceRequest', 'NewProviderRegistration', 'SubscriptionExpiry', 'Other'],
                'null' => false,
            ],
            'payload' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'is_read' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['recipient_id', 'is_read'], false, false, 'ix_notif_recipient');
        $this->forge->addKey('type', false, false, 'ix_notif_type');
        $this->forge->createTable('notifications');

        // Set timestamp default
        $this->db->query('ALTER TABLE notifications MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        // Add foreign key constraint
        $this->db->query('ALTER TABLE notifications 
                         ADD CONSTRAINT fk_notif_user 
                         FOREIGN KEY (recipient_id) REFERENCES users(id) 
                         ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
