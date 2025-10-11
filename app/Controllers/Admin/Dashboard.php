<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $stats = [
            'sales' => 1500000,
            'products' => 25,
            'orders' => 8,
            'visitors' => 120,
            'lowstock' => 3
        ];

        $chart_labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $chart_sales = [120000, 150000, 90000, 170000, 140000, 190000, 220000];

        $products = [
            ['id' => 1, 'name' => 'Kaos Polos', 'price' => 80000, 'stock' => 10],
            ['id' => 2, 'name' => 'Sweater Hoodie', 'price' => 150000, 'stock' => 4],
            ['id' => 3, 'name' => 'Topi Custom', 'price' => 60000, 'stock' => 0],
        ];

        return view('admin/dashboard', compact('stats', 'chart_labels', 'chart_sales', 'products'));
    }
}
