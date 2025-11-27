<?php

namespace App\Controllers;

use App\Models\KontakModel;
use App\Models\HomeSettingModel;
use App\Models\GeneralSettingModel;

class Kontak extends BaseController
{
    public function index()
    {
        $homeSettingModel = new HomeSettingModel();
        $generalSettingModel = new GeneralSettingModel();

        if (!$homeSettings = cache('home_settings')) {
            $homeSettings = $homeSettingModel->first();
            cache()->save('home_settings', $homeSettings, 3600);
        }

        if (!$generalSettings = cache('general_settings')) {
            $generalSettings = $generalSettingModel->first();
            cache()->save('general_settings', $generalSettings, 3600);
        }

        $data = [
            'title' => 'Kontak Kami',
            'settings' => [
                'home' => $homeSettings,
                'general' => $generalSettings
            ]
        ];
        return view('kontak/kontak', $data);
    }

    public function kirim()
    {
        $kontakModel = new KontakModel();

        $data = [
            'nama' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subjek' => $this->request->getPost('subject'),
            'pesan' => $this->request->getPost('message')
        ];

        $kontakModel->save($data);

        return redirect()->to('/kontak')->with('success', 'Pesan Anda telah berhasil dikirim.');
    }
}
