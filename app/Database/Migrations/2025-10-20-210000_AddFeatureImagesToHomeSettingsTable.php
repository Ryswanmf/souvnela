<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeatureImagesToHomeSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('home_settings', [
            'feature1_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'feature2_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'feature3_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('home_settings', ['feature1_image', 'feature2_image', 'feature3_image']);
    }
}