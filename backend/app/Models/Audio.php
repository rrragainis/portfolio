<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $fillable = [
        'latvian_name',
        'english_name',
        'latvian_description',
        'english_description',
        'image_link',
        'cropped_image',
        'mp3_file'
    ];
}
