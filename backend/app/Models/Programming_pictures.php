<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programming_pictures extends Model
{
    protected $fillable = [
        'programming_id',
        'image_link'
    ];

    public function programming()
    {
        return $this->belongsTo(Programming::class);
    }
}
