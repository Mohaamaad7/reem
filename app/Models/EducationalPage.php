<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalPage extends Model
{
    protected $fillable = [
        'slug',
        'title_ar',
        'title_en',
        'intro_ar',
        'intro_en',
        'sections',
        'hero_image',
    ];

    protected $casts = [
        'sections' => 'array',
    ];
}
