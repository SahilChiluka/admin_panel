<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AccessLevel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'access_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
                'constraint' => 10
            ],
            'access_level' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
        $this->forge->addKey('access_id',true);
        $this->forge->createTable('accesslevels');
    }

    public function down()
    {
        $this->forge->dropTable('accesslevels');
    }
}
