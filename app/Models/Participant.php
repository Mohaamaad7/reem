<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['code', 'name', 'status', 'started_at', 'completed_at'];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function surveyResponse()
    {
        return $this->hasOne(SurveyResponse::class);
    }

    public function usageSession()
    {
        return $this->hasOne(UsageSession::class);
    }

    public function savedDesigns()
    {
        return $this->hasMany(SavedDesign::class);
    }

    /**
     * توليد كود عشوائي من 4 أرقام غير مكرر
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = str_pad(random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
