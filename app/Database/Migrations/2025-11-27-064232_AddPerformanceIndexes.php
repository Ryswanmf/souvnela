<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // Add indexes for better query performance

        // Produk table indexes
        $this->forge->addKey('is_unggulan', false, false, 'produk_is_unggulan_index');
        $this->forge->addKey('kategori', false, false, 'produk_kategori_index');
        $this->forge->processIndexes('produk');

        // Reviews table indexes
        $this->forge->addKey('produk_id', false, false, 'reviews_produk_id_index');
        $this->forge->addKey('status', false, false, 'reviews_status_index');
        $this->forge->addKey(['produk_id', 'status'], false, false, 'reviews_produk_status_index');
        $this->forge->processIndexes('reviews');

        // Wishlist table indexes
        $this->forge->addKey('user_id', false, false, 'wishlist_user_id_index');
        $this->forge->addKey('produk_id', false, false, 'wishlist_produk_id_index');
        $this->forge->addKey(['user_id', 'produk_id'], false, false, 'wishlist_user_produk_index');
        $this->forge->processIndexes('wishlist');

        // Session table index (if using database sessions)
        $this->forge->addKey('timestamp', false, false, 'ci_sessions_timestamp_index');
        $this->forge->processIndexes('ci_sessions');
    }

    public function down()
    {
        // Remove indexes (in reverse order)

        // Session table
        $this->forge->dropKey('ci_sessions', 'ci_sessions_timestamp_index');

        // Wishlist table
        $this->forge->dropKey('wishlist', 'wishlist_user_produk_index');
        $this->forge->dropKey('wishlist', 'wishlist_produk_id_index');
        $this->forge->dropKey('wishlist', 'wishlist_user_id_index');

        // Reviews table
        $this->forge->dropKey('reviews', 'reviews_produk_status_index');
        $this->forge->dropKey('reviews', 'reviews_status_index');
        $this->forge->dropKey('reviews', 'reviews_produk_id_index');

        // Produk table
        $this->forge->dropKey('produk', 'produk_kategori_index');
        $this->forge->dropKey('produk', 'produk_is_unggulan_index');
    }
}
