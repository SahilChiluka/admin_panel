<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Campaigns extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'camp_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'constraint' => 10
            ],
            'campaign_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'client' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'supervisor' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
        $this->forge->addKey('camp_id',true);
        $this->forge->createTable('campaigns');
    }

    public function down()
    {
        $this->forge->dropTable('campaigns');
    }
}
