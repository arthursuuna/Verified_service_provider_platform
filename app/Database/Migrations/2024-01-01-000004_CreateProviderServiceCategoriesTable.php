<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProviderServiceCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'provider_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'category_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey(['provider_id', 'category_id'], true);
        $this->forge->createTable('provider_service_categories');

        // Add foreign key constraints with raw SQL for better control
        $this->db->query('ALTER TABLE provider_service_categories 
                         ADD CONSTRAINT fk_psc_provider 
                         FOREIGN KEY (provider_id) REFERENCES service_providers(id) 
                         ON DELETE CASCADE ON UPDATE CASCADE');

        $this->db->query('ALTER TABLE provider_service_categories 
                         ADD CONSTRAINT fk_psc_category 
                         FOREIGN KEY (category_id) REFERENCES service_categories(id) 
                         ON DELETE RESTRICT ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('provider_service_categories');
    }
}
