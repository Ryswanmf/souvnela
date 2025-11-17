<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVisiMisiToHomeSettings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('home_settings', [
            'about_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'about_list3',
            ],
            'visi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'about_image',
            ],
            'misi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'visi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('home_settings', ['about_image', 'visi', 'misi']);
    }
}