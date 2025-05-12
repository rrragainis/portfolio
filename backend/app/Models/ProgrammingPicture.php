<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammingPicture extends Model
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