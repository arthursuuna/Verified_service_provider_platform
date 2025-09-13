<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRatingsTable extends Migration
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
            'rating' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'unsigned' => true,
                'null' => false,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('service_provider_id', false, false, 'ix_rating_provider');
        $this->forge->addKey('user_id', false, false, 'ix_rating_user');
        $this->forge->createTable('ratings');

        // Set timestamp default
        $this->db->query('ALTER TABLE ratings MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');

        // Add check constraint for rating between 1 and 5
        $this->db->query('ALTER TABLE ratings ADD CONSTRAINT chk_rating_range CHECK (rating BETWEEN 1 AND 5)');

        // Add foreign key constraints
        $this->db->query('ALTER TABLE ratings 
                         ADD CONSTRAINT fk_rating_user 
                         FOREIGN KEY (user_id) REFERENCES users(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');

        $this->db->query('ALTER TABLE ratings 
                         ADD CONSTRAINT fk_rating_provider 
                         FOREIGN KEY (service_provider_id) REFERENCES service_providers(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('ratings');
    }
}
