<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGeneralSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'whatsapp_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'whatsapp_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('general_settings');
    }

    public function down()
    {
        $this->forge->dropTable('general_settings');
    }
}
