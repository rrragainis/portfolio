<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function convertToWebP($imagePath, $quality = 80)
    {
        $image = $this->manager->read($imagePath);
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imagePath);
        
        $image->toWebp($quality)->save($webpPath);
        
        return $webpPath;
    }
} 