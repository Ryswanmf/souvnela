<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\PesananItemModel;

class Pesanan extends BaseController
{
    public function index()
    {
        $model = new PesananModel();
        $data = [
            'pesanan' => $model->orderBy('created_at', 'DESC')->findAll(), 
            'pageTitle' => 'Daftar Pesanan'
        ];

        return view('admin/pesanan', $data);
    }

    public function detail($id)
    {
        $pesananModel = new PesananModel();
        $pesananItemModel = new PesananItemModel();

        $pesanan = $pesananModel->find($id);

        if (!$pesanan) {
            return redirect()->to('admin/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $items = $pesananItemModel->where('pesanan_id', $id)->findAll();

        $data = [
            'title' => 'Detail Pesanan ' . $pesanan['kode'],
            'pesanan' => $pesanan,
            'items' => $items
        ];

        return view('admin/pesanan/detail', $data);
    }

    public function updateStatus($id)
    {
        $model = new PesananModel();
        $status = $this->request->getPost('status');

        // Validate the status
        $allowedStatus = ['Proses', 'Selesai', 'Dibatalkan'];
        if (!in_array($status, $allowedStatus)) {
            return redirect()->to('admin/pesanan')->with('error', 'Status tidak valid.');
        }

        $model->update($id, ['status' => $status]);

        return redirect()->to('admin/pesanan')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
