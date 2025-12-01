<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PesananItemModel;

class Invoice extends BaseController
{
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

        // Base query: Only show orders that have some form of payment or are delivered
        // Typically invoices are generated for 'settlement', 'capture', or 'delivered' orders.
        $builder = $this->pesananModel->builder();
        
        // We want to list all orders, but maybe highlight those ready for invoice
        // Or strictly filter? Let's show all but allow filtering.
        
        $builder->select('pesanan.*, users.username as nama_user');
        $builder->join('users', 'users.id = pesanan.user_id', 'left');
        $builder->orderBy('pesanan.created_at', 'DESC');

        if ($startDate) {
            $builder->where('DATE(pesanan.created_at) >=', $startDate);
        }

        if ($endDate) {
            $builder->where('DATE(pesanan.created_at) <=', $endDate);
        }

        if ($status) {
            $builder->where('pesanan.status', $status);
        } else {
            // Default view: Show paid or processed/shipped/delivered
            // Excluding 'pending' or 'cancelled' might be better for an "Invoice" menu, 
            // but let's keep it flexible.
            // $builder->whereIn('pesanan.status', ['processing', 'shipped', 'delivered']);
        }

        // Pagination
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        
        // Note: CodeIgniter Model pagination is easier, but for complex joins sometimes builder is used.
        // Let's switch back to Model for easier pagination if possible, but manual join is fine.
        
        // Using Model method for easier pagination
        $this->pesananModel->select('pesanan.*, users.username as nama_user')
                           ->join('users', 'users.id = pesanan.user_id', 'left')
                           ->orderBy('pesanan.created_at', 'DESC');

        if ($startDate) {
            $this->pesananModel->where('DATE(pesanan.created_at) >=', $startDate);
        }
        if ($endDate) {
            $this->pesananModel->where('DATE(pesanan.created_at) <=', $endDate);
        }
        if ($status) {
            $this->pesananModel->where('status', $status);
        } else {
             // Optional: default filter
        }

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
