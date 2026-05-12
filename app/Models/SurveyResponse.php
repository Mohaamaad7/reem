<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    protected $fillable = [
        'participant_id', 'participant_code', 'participant_name',
        'fabric_chosen', 'pattern_chosen', 'patterns_chosen',
        'tool_ease_rating', 'tool_visual_rating',
        'morris_knowledge_before', 'morris_knowledge_after',
        'technique_clarity', 'eco_fabric_awareness',
        'app_overall_rating', 'app_usefulness', 'would_recommend',
        'most_liked', 'improvement_suggestions', 'design_ideas',
        'language_used', 'device_type', 'time_spent_seconds',
        'synced_to_sheets', 'sheets_row_id',
    ];

    protected $casts = [
        'synced_to_sheets' => 'boolean',
        'patterns_chosen' => 'array',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
