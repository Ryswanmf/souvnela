<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusTrackingToPesanan extends Migration
{
    public function up()
    {
        $db = $this->db;
        $fields = $db->getFieldNames('pesanan');
        
        // Drop old status column if exists
        if (in_array('status', $fields)) {
            $this->forge->dropColumn('pesanan', 'status');
        }
        
        // Determine which total column exists
        $afterColumn = in_array('total_harga', $fields) ? 'total_harga' : 'total';
        
        // Add new columns
        $newFields = [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
                'default'    => 'pending',
                'after'      => $afterColumn,
            ],
            'tracking_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status',
            ],
            'shipped_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'tracking_number',
            ],
            'delivered_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'shipped_at',
            ],
        ];
        
        $this->forge->addColumn('pesanan', $newFields);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', ['status', 'tracking_number', 'shipped_at', 'delivered_at']);
    }
}
