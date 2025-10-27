<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\HomeSettingModel;
use App\Models\GeneralSettingModel;

abstract class BaseController extends Controller
{
    protected $helpers = ['form', 'url', 'number'];

    protected $settings;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $homeSettingModel = new HomeSettingModel();
        $homeSettings = $homeSettingModel->first();

        $generalSettingModel = new GeneralSettingModel();
        $generalSettings = $generalSettingModel->first();
        if (empty($generalSettings)) {
            $generalSettingModel->insert([
                'whatsapp_number' => '6281234567890',
                'whatsapp_message' => 'Halo Souvnela, saya tertarik dengan produk souvenir Polinela.',
                'copyright_text' => '&copy; ' . date('Y') . ' Souvnela - Souvenir Eksklusif Polinela. Proyek Mandiri.',
            ]);
            $generalSettings = $generalSettingModel->first();
        }

        $this->settings = [
            'home' => $homeSettings,
            'general' => $generalSettings
        ];

        log_message('debug', 'BaseController settings: ' . json_encode($this->settings));

        \Config\Services::renderer()->setVar('settings', $this->settings);
    }
}
