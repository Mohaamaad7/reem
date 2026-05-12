<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'fabric_id',
        'blend_mode',
        'opacity',
        'patterns_used',
        'canvas_json',
        'preview_image',
    ];

    protected $casts = [
        'patterns_used' => 'array',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
