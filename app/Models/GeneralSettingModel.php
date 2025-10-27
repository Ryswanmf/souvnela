<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralSettingModel extends Model
{
    protected $table = 'general_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['whatsapp_number', 'whatsapp_message', 'copyright_text'];
}
