<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHomeSettingsTable extends Migration
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
            'hero_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'hero_subtitle1' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hero_subtitle2' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hero_button_text' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'hero_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'features_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature1_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature1_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature1_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'feature2_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature2_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature2_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'feature3_icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature3_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'feature3_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'about_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'about_description1' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'about_description2' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'about_list1' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'about_list2' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'about_list3' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'contact_title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'contact_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'contact_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'contact_instagram' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'contact_tiktok' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'contact_email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('home_settings');
    }

    public function down()
    {
        $this->forge->dropTable('home_settings');
    }
}
