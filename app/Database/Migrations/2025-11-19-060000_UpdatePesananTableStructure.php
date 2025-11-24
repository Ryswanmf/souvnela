<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePesananTableStructure extends Migration
{
    public function up()
    {
        // Check if columns exist and add/modify as needed
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('pesanan');
        
        // Add user_id if not exists
        if (!in_array('user_id', $fields)) {
            $this->forge->addColumn('pesanan', [
                'user_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id',
                ],
            ]);
        }
        
        // Add shipping info columns if not exist
        if (!in_array('nama_penerima', $fields)) {
            $this->forge->addColumn('pesanan', [
                'nama_penerima' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'user_id',
                ],
                'alamat_lengkap' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'nama_penerima',
                ],
                'no_telepon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'alamat_lengkap',
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'no_telepon',
                ],
                'catatan' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'after' => 'email',
                ],
            ]);
        }
        
        // Rename total to total_harga if needed
        if (in_array('total', $fields) && !in_array('total_harga', $fields)) {
            $this->forge->modifyColumn('pesanan', [
                'total' => [
                    'name'       => 'total_harga',
                    'type'       => 'DECIMAL',
                    'constraint' => '15,2',
                ],
            ]);
        }
    }

    public function down()
    {
        $fields = ['user_id', 'nama_penerima', 'alamat_lengkap', 'no_telepon', 'email', 'catatan'];
        $this->forge->dropColumn('pesanan', $fields);
        
        // Rename back
        $this->forge->modifyColumn('pesanan', [
            'total_harga' => [
                'name'       => 'total',
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);
    }
}
