<?php
// File: check_featured.php
// Place this in public/ to run via browser or CLI

// Load CodeIgniter core
$appPath = __DIR__ . '/../app';
$publicPath = __DIR__;

require $publicPath . '/index.php';

use App\Models\ProdukModel;

// Manual bootstrap to use models outside controller flow if needed, 
// but since we included index.php, CI is loaded. We just need to execute logic.

$model = new ProdukModel();
$count = $model->where('is_unggulan', 1)->countAllResults();
$allProducts = $model->countAllResults();

echo "Total Produk: " . $allProducts . "\n";
echo "Produk Unggulan (is_unggulan = 1): " . $count . "\n";

if ($count == 0) {
    echo "TIDAK ADA produk unggulan. Mengatur 3 produk pertama menjadi unggulan...\n";
    $products = $model->limit(3)->find();
    if (!empty($products)) {
        foreach ($products as $p) {
            $model->update($p['id'], ['is_unggulan' => 1]);
            echo "Produk ID " . $p['id'] . " (" . $p['nama'] . ") diatur sebagai unggulan.\n";
        }
    } else {
        echo "Database produk kosong.\n";
    }
}

// Clear cache
cache()->delete('featured_products');
echo "Cache 'featured_products' dihapus.\n";

