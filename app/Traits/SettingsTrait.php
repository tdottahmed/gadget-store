<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

trait SettingsTrait
{
    use StorageTrait;

    public function setEnvironmentValue($envKey, $envValue): mixed
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        
        // Escape the key for regex
        $escapedKey = preg_quote($envKey, '/');
        
        // Pattern to match the key at start of line with any value
        $pattern = "/^[\s]*{$escapedKey}=.*$/m";
        
        $newLine = "{$envKey}={$envValue}";
        
        if (preg_match($pattern, $str)) {
            // Key exists, replace all occurrences with a single clean line
            $str = preg_replace($pattern, '', $str);
            // Remove empty lines that might have been created
            $str = preg_replace("/\n\n+/", "\n", $str);
            // Add the new line at the end
            $str = rtrim($str) . "\n{$newLine}\n";
        } else {
            // Key doesn't exist, append it
            $str = rtrim($str) . "\n{$newLine}\n";
        }
        
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }

    public function getSettings($object, $type)
    {
        $config = null;
        foreach ($object as $setting) {
            if ($setting['type'] == $type) {
                $config = $this->storageDataProcessing($type, $setting);
            }
        }
        return $config;
    }

    private function storageDataProcessing($name, $value)
    {
        $arrayOfCompaniesValue = ['company_web_logo', 'company_mobile_logo', 'company_footer_logo', 'company_fav_icon', 'loader_gif', 'blog_feature_download_app_icon', 'blog_feature_download_app_background'];
        if (in_array($name, $arrayOfCompaniesValue)) {
            $imageData = json_decode($value->value, true) ?? ['image_name' => $value['value'], 'storage' => 'public'];
            $value['value'] = $this->storageLink('company', $imageData['image_name'], $imageData['storage']);
        }
        return $value;
    }
}
