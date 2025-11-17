<?php

namespace App\Controllers\Admin;

use App\Models\HomeSettingModel;
use App\Models\GeneralSettingModel;
use App\Controllers\BaseController;

class Setting extends BaseController
{
    protected $homeSettingModel;
    protected $generalSettingModel;

    public function __construct()
    {
        $this->homeSettingModel = new HomeSettingModel();
        $this->generalSettingModel = new GeneralSettingModel();
    }

    public function hero()
    {
        $settings = $this->homeSettingModel->first();
        $data = [
            'title' => 'Pengaturan Hero Section',
            'settings' => $settings
        ];

        return view('admin/setting/hero', $data);
    }

    public function update_hero()
    {
        $data = [
            'hero_title' => $this->request->getPost('hero_title'),
            'hero_subtitle1' => $this->request->getPost('hero_subtitle1'),
            'hero_subtitle2' => $this->request->getPost('hero_subtitle2'),
            'hero_button_text' => $this->request->getPost('hero_button_text'),
        ];

        // Handle file upload
        $heroImage = $this->request->getFile('hero_image');
        if ($heroImage->isValid() && !$heroImage->hasMoved()) {
            $currentSettings = $this->homeSettingModel->first();
            if ($currentSettings && !empty($currentSettings['hero_image'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $currentSettings['hero_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newName = $heroImage->getRandomName();
            $heroImage->move(ROOTPATH . 'public/uploads', $newName);
            $data['hero_image'] = $newName;
        }

        $currentSettings = $this->homeSettingModel->first();
        if ($currentSettings) {
            $this->homeSettingModel->update($currentSettings['id'], $data);
        } else {
            $this->homeSettingModel->insert($data);
        }

        return redirect()->to('admin/setting/hero')->with('success', 'Pengaturan Hero Section berhasil diperbarui.');
    }

    public function features()
    {
        $settings = $this->homeSettingModel->first();
        $data = [
            'title' => 'Pengaturan Features Section',
            'settings' => $settings
        ];

        return view('admin/setting/features', $data);
    }

    public function update_features()
    {
        $data = [
            'features_title' => $this->request->getPost('features_title'),
            'feature1_icon' => $this->request->getPost('feature1_icon'),
            'feature1_title' => $this->request->getPost('feature1_title'),
            'feature1_description' => $this->request->getPost('feature1_description'),
            'feature2_icon' => $this->request->getPost('feature2_icon'),
            'feature2_title' => $this->request->getPost('feature2_title'),
            'feature2_description' => $this->request->getPost('feature2_description'),
            'feature3_icon' => $this->request->getPost('feature3_icon'),
            'feature3_title' => $this->request->getPost('feature3_title'),
            'feature3_description' => $this->request->getPost('feature3_description'),
        ];

        // Handle file uploads for feature images
        $feature1Image = $this->request->getFile('feature1_image');
        if ($feature1Image->isValid() && !$feature1Image->hasMoved()) {
            $currentSettings = $this->homeSettingModel->first();
            if ($currentSettings && !empty($currentSettings['feature1_image'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $currentSettings['feature1_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $newName = $feature1Image->getRandomName();
            $feature1Image->move(ROOTPATH . 'public/uploads', $newName);
            $data['feature1_image'] = $newName;
        }

        $feature2Image = $this->request->getFile('feature2_image');
        if ($feature2Image->isValid() && !$feature2Image->hasMoved()) {
            $currentSettings = $this->homeSettingModel->first();
            if ($currentSettings && !empty($currentSettings['feature2_image'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $currentSettings['feature2_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $newName = $feature2Image->getRandomName();
            $feature2Image->move(ROOTPATH . 'public/uploads', $newName);
            $data['feature2_image'] = $newName;
        }

        $feature3Image = $this->request->getFile('feature3_image');
        if ($feature3Image->isValid() && !$feature3Image->hasMoved()) {
            $currentSettings = $this->homeSettingModel->first();
            if ($currentSettings && !empty($currentSettings['feature3_image'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $currentSettings['feature3_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $newName = $feature3Image->getRandomName();
            $feature3Image->move(ROOTPATH . 'public/uploads', $newName);
            $data['feature3_image'] = $newName;
        }

        $currentSettings = $this->homeSettingModel->first();
        if ($currentSettings) {
            $this->homeSettingModel->update($currentSettings['id'], $data);
        } else {
            $this->homeSettingModel->insert($data);
        }

        return redirect()->to('admin/setting/features')->with('success', 'Pengaturan Features Section berhasil diperbarui.');
    }

    public function about()
    {
        $settings = $this->homeSettingModel->first();
        $data = [
            'title' => 'Pengaturan Tentang Section',
            'settings' => $settings
        ];

        return view('admin/setting/about', $data);
    }

    public function update_about()
    {
        $data = [
            'about_title' => $this->request->getPost('about_title'),
            'about_description1' => $this->request->getPost('about_description1'),
            'about_description2' => $this->request->getPost('about_description2'),
            'about_list1' => $this->request->getPost('about_list1'),
            'about_list2' => $this->request->getPost('about_list2'),
            'about_list3' => $this->request->getPost('about_list3'),
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),
            'footer_description' => $this->request->getPost('footer_description'),
        ];

        // Handle file upload for about_image
        $aboutImage = $this->request->getFile('about_image');
        if ($aboutImage && $aboutImage->isValid() && !$aboutImage->hasMoved()) {
            $currentSettings = $this->homeSettingModel->first();
            if ($currentSettings && !empty($currentSettings['about_image'])) {
                $oldImagePath = ROOTPATH . 'public/uploads/' . $currentSettings['about_image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $newName = $aboutImage->getRandomName();
            $aboutImage->move(ROOTPATH . 'public/uploads', $newName);
            $data['about_image'] = $newName;
        }

        $currentSettings = $this->homeSettingModel->first();
        if ($currentSettings) {
            $this->homeSettingModel->update($currentSettings['id'], $data);
        } else {
            $this->homeSettingModel->insert($data);
        }

        return redirect()->to('admin/setting/about')->with('success', 'Pengaturan Tentang Section berhasil diperbarui.');
    }

    public function contact()
    {
        $settings = $this->homeSettingModel->first();
        $data = [
            'title' => 'Pengaturan Kontak Section',
            'settings' => $settings
        ];

        return view('admin/setting/contact', $data);
    }

    public function update_contact()
    {
        $data = [
            'contact_title' => $this->request->getPost('contact_title'),
            'contact_address' => $this->request->getPost('contact_address'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_instagram' => $this->request->getPost('contact_instagram'),
            'contact_tiktok' => $this->request->getPost('contact_tiktok'),
            'contact_email' => $this->request->getPost('contact_email'),
        ];

        $currentSettings = $this->homeSettingModel->first();
        if ($currentSettings) {
            $this->homeSettingModel->update($currentSettings['id'], $data);
        } else {
            $this->homeSettingModel->insert($data);
        }

        return redirect()->to('admin/setting/contact')->with('success', 'Pengaturan Kontak Section berhasil diperbarui.');
    }

    public function general()
    {
        $settings = $this->generalSettingModel->first();
        $data = [
            'title' => 'Pengaturan Umum',
            'settings' => $settings
        ];

        return view('admin/setting/general', $data);
    }

    public function update_general()
    {
        $data = [
            'whatsapp_number' => $this->request->getPost('whatsapp_number'),
            'whatsapp_message' => $this->request->getPost('whatsapp_message'),
            'copyright_text' => $this->request->getPost('copyright_text'),
        ];

        $currentSettings = $this->generalSettingModel->first();
        if ($currentSettings) {
            $this->generalSettingModel->update($currentSettings['id'], $data);
        } else {
            $this->generalSettingModel->insert($data);
        }

        return redirect()->to('admin/setting/general')->with('success', 'Pengaturan Umum berhasil diperbarui.');
    }
}