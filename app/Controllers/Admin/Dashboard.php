<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\PesananModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();
        $pesananModel = new PesananModel();

        // Kalkulasi Statistik
        $totalSales = $pesananModel->selectSum('total_harga')->where('status', 'delivered')->first()['total_harga'] ?? 0;
        $totalProducts = $produkModel->countAllResults();
        $totalOrders = $pesananModel->countAllResults();
        $lowStock = $produkModel->where('stok <', 5)->countAllResults();

        $stats = [
            'sales'    => $totalSales,
            'products' => $totalProducts,
            'orders'   => $totalOrders,
            'visitors' => 120, // Data statis untuk saat ini
            'lowstock' => $lowStock
        ];

        // Data untuk chart
        $chart_labels = [];
        $chart_sales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $chart_labels[] = date('D', strtotime($date));
            $daily_sale = $pesananModel->selectSum('total_harga')
                                      ->where('status', 'delivered')
                                      ->where('DATE(created_at)', $date)
                                      ->first()['total_harga'] ?? 0;
            $chart_sales[] = $daily_sale;
        }

        // Ambil beberapa produk terbaru untuk ditampilkan di tabel
        $products = $produkModel->orderBy('id', 'DESC')->limit(5)->findAll();

        return view('admin/dashboard', compact('stats', 'chart_labels', 'chart_sales', 'products'));
    }
}