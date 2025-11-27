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

        // Cache settings for 1 hour (3600 seconds)
        if (!$this->settings = cache('app_settings')) {
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
            
            cache()->save('app_settings', $this->settings, 3600);
        }

        \Config\Services::renderer()->setVar('settings', $this->settings);

        // Load navbar data (wishlist count and cart count) for performance
        $this->loadNavbarData();
    }

    /**
     * Load navbar data (wishlist count, cart count) for performance optimization
     * This prevents database queries in views on every page load
     */
    protected function loadNavbarData()
    {
        $navbarData = [];

        // Calculate cart total items (from session)
        $cart = session()->get('cart') ?? [];
        $navbarData['cartTotalItems'] = 0;
        foreach ($cart as $item) {
            $navbarData['cartTotalItems'] += $item['quantity'];
        }

        // Get wishlist count (only for logged in users)
        $navbarData['wishlistCount'] = 0;
        if (session()->get('isLoggedIn')) {
            // Cache wishlist count per user for 5 minutes
            $cacheKey = 'wishlist_count_' . session()->get('id');
            if (!$navbarData['wishlistCount'] = cache($cacheKey)) {
                $wishlistModel = new \App\Models\WishlistModel();
                $navbarData['wishlistCount'] = $wishlistModel->where('user_id', session()->get('id'))->countAllResults();
                cache()->save($cacheKey, $navbarData['wishlistCount'], 300); // 5 minutes
            }
        }

        \Config\Services::renderer()->setVar('navbarData', $navbarData);
    }
}
