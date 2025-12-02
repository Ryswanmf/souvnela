<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PesananItemModel;

class Invoice extends BaseController
{
    protected $request;
    protected $pesananModel;
    protected $itemModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->itemModel = new PesananItemModel();
    }

    public function index()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $status = $this->request->getGet('status');

        // Using Model method for pagination with joins
        $this->pesananModel->select('pesanan.*, u.username as nama_user')
                           ->join('users as u', 'u.id = pesanan.user_id', 'left')
                           ->orderBy('pesanan.created_at', 'DESC');

        if ($startDate) {
            $this->pesananModel->where('DATE(pesanan.created_at) >=', $startDate);
        }
        if ($endDate) {
            $this->pesananModel->where('DATE(pesanan.created_at) <=', $endDate);
        }
        if ($status) {
            $this->pesananModel->where('status', $status);
        }
        // Optional: default filter for invoices (e.g., only paid orders)
        // $this->pesananModel->whereIn('status', ['processing', 'shipped', 'delivered']);

        $perPage = 10;
        $invoices = $this->pesananModel->paginate($perPage, 'invoices');
        $pager = $this->pesananModel->pager;

        $data = [
            'title' => 'Data Invoice',
            'invoices' => $invoices,
            'pager' => $pager,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status
        ];

        return view('admin/invoice/index', $data);
    }

    // Use the existing print method logic, but maybe wrapped here if needed.
    // Or just link to the existing Orders/Pesanan invoice route.
    // We'll link to the existing route to avoid duplication, or duplicate if we want specific admin invoice logic.
    // For now, we reuse the Admin/Pesanan::invoice method via route, or creating a proxy here.
    
    public function print($id)
    {
        // Re-using the logic from Pesanan Controller to ensure consistency
        // Alternatively, redirect to that route
        return redirect()->to('admin/pesanan/invoice/' . $id);
    }
}
