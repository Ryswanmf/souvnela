<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeSettingModel extends Model
{
    protected $table = 'home_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'hero_title', 'hero_subtitle1', 'hero_subtitle2', 'hero_button_text', 'hero_image',
        'features_title', 'feature1_icon', 'feature1_title', 'feature1_description', 'feature2_icon', 'feature2_title', 'feature2_description', 'feature3_icon', 'feature3_title', 'feature3_description',
        'about_title', 'about_description1', 'about_description2', 'about_list1', 'about_list2', 'about_list3',
        'contact_title', 'contact_address', 'contact_phone', 'contact_instagram', 'contact_tiktok', 'contact_email',
        'footer_description', 'feature1_image', 'feature2_image', 'feature3_image', 'feature1_image', 'feature2_image', 'feature3_image'
    ];
}
