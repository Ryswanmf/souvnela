<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToTestimonialsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('testimonials', [
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('testimonials', 'photo');
    }
}
