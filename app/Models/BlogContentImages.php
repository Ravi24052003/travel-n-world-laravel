<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogContentImages extends Model
{
    use HasFactory;

    protected $table = 'blog_content_images';

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
    ];
}
