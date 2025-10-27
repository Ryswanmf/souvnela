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
        $totalSales = $pesananModel->selectSum('total')->where('status', 'Selesai')->first()['total'] ?? 0;
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

        // Data untuk chart (statis untuk saat ini)
        $chart_labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $chart_sales = [120000, 150000, 90000, 170000, 140000, 190000, 220000];

        // Ambil beberapa produk terbaru untuk ditampilkan di tabel
        $products = $produkModel->orderBy('id', 'DESC')->limit(5)->findAll();

        return view('admin/dashboard', compact('stats', 'chart_labels', 'chart_sales', 'products'));
    }
}