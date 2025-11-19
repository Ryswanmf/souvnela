<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Config\Midtrans as MidtransConfig;

class Midtrans extends BaseController
{
    public function index()
    {
        $midtransConfig = new MidtransConfig();

        $data = [
            'title' => 'Midtrans Settings',
            'serverKey' => $midtransConfig->serverKey,
            'clientKey' => $midtransConfig->clientKey,
            'isProduction' => $midtransConfig->isProduction,
        ];

        return view('admin/midtrans/index', $data);
    }

    public function update()
    {
        $serverKey = $this->request->getPost('serverKey');
        $clientKey = $this->request->getPost('clientKey');
        $isProduction = $this->request->getPost('isProduction');

        $configPath = APPPATH . 'Config/Midtrans.php';
        $configContent = file_get_contents($configPath);

        $configContent = preg_replace("/'serverKey' => '.*?'/", "'serverKey' => '{$serverKey}'", $configContent);
        $configContent = preg_replace("/'clientKey' => '.*?'/", "'clientKey' => '{$clientKey}'", $configContent);
        $configContent = preg_replace("/'isProduction' => (true|false)/", "'isProduction' => " . ($isProduction ? 'true' : 'false'), $configContent);

        file_put_contents($configPath, $configContent);

        return redirect()->to('admin/midtrans')->with('success', 'Midtrans settings updated successfully.');
    }
}
