<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    /**
     * Midtrans Server Key
     * Get from: https://dashboard.midtrans.com/settings/config_info
     */
    public $serverKey = 'SB-Mid-server-YOUR_SERVER_KEY_HERE';
    
    /**
     * Midtrans Client Key
     */
    public $clientKey = 'SB-Mid-client-YOUR_CLIENT_KEY_HERE';
    
    /**
     * Set to true for production
     */
    public $isProduction = false;
    
    /**
     * Enable sanitization
     */
    public $isSanitized = true;
    
    /**
     * Enable 3D Secure
     */
    public $is3ds = true;
}
