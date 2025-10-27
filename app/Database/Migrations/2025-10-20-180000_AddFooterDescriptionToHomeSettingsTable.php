<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFooterDescriptionToHomeSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('home_settings', [
            'footer_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('home_settings', 'footer_description');
    }
}
