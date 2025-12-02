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
        $data = [
            'title' => 'Manajemen Voucher',
            'vouchers' => $this->voucherModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/voucher/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Voucher Baru'
        ];

        return view('admin/voucher/create', $data);
    }

    public function store()
    {
        $rules = [
            'code' => 'required|min_length[3]|is_unique[vouchers.code]',
            'discount_type' => 'required|in_list[fixed,percentage]',
            'discount_value' => 'required|numeric',
            'valid_from' => 'required|valid_date',
            'valid_until' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'code' => strtoupper($this->request->getPost('code')),
            'description' => $this->request->getPost('description'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'min_purchase' => $this->request->getPost('min_purchase') ?: 0,
            'max_discount' => $this->request->getPost('max_discount') ?: 0,
            'usage_limit' => $this->request->getPost('usage_limit') ?: 0,
            'valid_from' => $this->request->getPost('valid_from'),
            'valid_until' => $this->request->getPost('valid_until') . ' 23:59:59', // End of day
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->voucherModel->save($data)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan voucher.');
    }

    public function edit($id)
    {
        $voucher = $this->voucherModel->find($id);

        if (!$voucher) {
            return redirect()->to('/admin/voucher')->with('error', 'Voucher tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Voucher',
            'voucher' => $voucher
        ];

        return view('admin/voucher/edit', $data);
    }

    public function update($id)
    {
        $voucher = $this->voucherModel->find($id);

        if (!$voucher) {
            return redirect()->to('/admin/voucher')->with('error', 'Voucher tidak ditemukan.');
        }

        $rules = [
            'code' => "required|min_length[3]|is_unique[vouchers.code,id,{$id}]",
            'discount_type' => 'required|in_list[fixed,percentage]',
            'discount_value' => 'required|numeric',
            'valid_from' => 'required|valid_date',
            'valid_until' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'code' => strtoupper($this->request->getPost('code')),
            'description' => $this->request->getPost('description'),
            'discount_type' => $this->request->getPost('discount_type'),
            'discount_value' => $this->request->getPost('discount_value'),
            'min_purchase' => $this->request->getPost('min_purchase') ?: 0,
            'max_discount' => $this->request->getPost('max_discount') ?: 0,
            'usage_limit' => $this->request->getPost('usage_limit') ?: 0,
            'valid_from' => $this->request->getPost('valid_from'),
            'valid_until' => $this->request->getPost('valid_until') . ' 23:59:59', // End of day
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->voucherModel->save($data)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui voucher.');
    }

    public function delete($id)
    {
        if ($this->voucherModel->delete($id)) {
            return redirect()->to('/admin/voucher')->with('success', 'Voucher berhasil dihapus.');
        }

        return redirect()->to('/admin/voucher')->with('error', 'Gagal menghapus voucher.');
    }

    public function toggleStatus($id)
    {
        $voucher = $this->voucherModel->find($id);
        if ($voucher) {
            $newStatus = !$voucher['is_active'];
            $this->voucherModel->update($id, ['is_active' => $newStatus]);
            return redirect()->back()->with('success', 'Status voucher diperbarui.');
        }
        return redirect()->back()->with('error', 'Voucher tidak ditemukan.');
    }
}