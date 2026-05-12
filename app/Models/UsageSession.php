<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsageSession extends Model
{
    protected $fillable = ['participant_id', 'pages_visited', 'design_tool_used', 'survey_completed'];

    protected $casts = [
        'pages_visited'    => 'array',
        'design_tool_used' => 'boolean',
        'survey_completed' => 'boolean',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
