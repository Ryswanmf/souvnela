<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VoucherModel;

class Voucher extends BaseController
{
    protected $voucherModel;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel();
    }

    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data['vouchers'] = $this->voucherModel->orderBy('created_at', 'DESC')->findAll();
        $data['title'] = 'Kelola Voucher';

        return view('admin/voucher/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data['title'] = 'Tambah Voucher';
        return view('admin/voucher/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $rules = [
            'code' => 'required|is_unique[vouchers.code]|alpha_numeric',
            'type' => 'required|in_list[percentage,fixed]',
            'value' => 'required|numeric',
            'valid_from' => 'required',
            'valid_until' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code' => strtoupper($this->request->getPost('code')),
            'type' => $this->request->getPost('type'),
            'value' => $this->request->getPost('value'),
            'min_purchase' => $this->request->getPost('min_purchase') ?? 0,
            'max_discount' => $this->request->getPost('max_discount') ?? 0,
            'usage_limit' => $this->request->getPost('usage_limit') ?? 0,
            'valid_from' => $this->request->getPost('valid_from'),
            'valid_until' => $this->request->getPost('valid_until'),
            'status' => 'active'
        ];

        if ($this->voucherModel->insert($data)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan voucher');
    }

    public function edit($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $data['voucher'] = $this->voucherModel->find($id);
        if (!$data['voucher']) {
            return redirect()->to('/admin/voucher')->with('error', 'Voucher tidak ditemukan');
        }

        $data['title'] = 'Edit Voucher';
        return view('admin/voucher/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        $voucher = $this->voucherModel->find($id);
        if (!$voucher) {
            return redirect()->to('/admin/voucher')->with('error', 'Voucher tidak ditemukan');
        }

        $rules = [
            'code' => "required|alpha_numeric|is_unique[vouchers.code,id,{$id}]",
            'type' => 'required|in_list[percentage,fixed]',
            'value' => 'required|numeric',
            'valid_from' => 'required',
            'valid_until' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code' => strtoupper($this->request->getPost('code')),
            'type' => $this->request->getPost('type'),
            'value' => $this->request->getPost('value'),
            'min_purchase' => $this->request->getPost('min_purchase') ?? 0,
            'max_discount' => $this->request->getPost('max_discount') ?? 0,
            'usage_limit' => $this->request->getPost('usage_limit') ?? 0,
            'valid_from' => $this->request->getPost('valid_from'),
            'valid_until' => $this->request->getPost('valid_until'),
            'status' => $this->request->getPost('status')
        ];

        if ($this->voucherModel->update($id, $data)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate voucher');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }

        if ($this->voucherModel->delete($id)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil dihapus');
        }

        return redirect()->to('/admin/voucher')->with('error', 'Gagal menghapus voucher');
    }

    public function toggleStatus($id)
    {
        if (session()->get('role') != 'admin') {
            return $this->response->setJSON(['success' => false]);
        }

        $voucher = $this->voucherModel->find($id);
        if (!$voucher) {
            return $this->response->setJSON(['success' => false]);
        }

        $newStatus = $voucher['status'] === 'active' ? 'inactive' : 'active';
        
        if ($this->voucherModel->update($id, ['status' => $newStatus])) {
            return $this->response->setJSON([
                'success' => true,
                'status' => $newStatus
            ]);
        }

        return $this->response->setJSON(['success' => false]);
    }
}
