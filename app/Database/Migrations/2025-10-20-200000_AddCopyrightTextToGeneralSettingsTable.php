<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCopyrightTextToGeneralSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('general_settings', [
            'copyright_text' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('general_settings', 'copyright_text');
    }
}
