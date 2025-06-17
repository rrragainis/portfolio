<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class ImageService
{
    public function convertToWebP($imagePath, $quality = 80)
    {
        $image = Image::make($imagePath);
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath);
        
        $image->encode('webp', $quality)->save($webpPath);
        
        return $webpPath;
    }
} 