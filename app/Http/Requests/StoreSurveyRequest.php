<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurveyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('participant_id');
    }

    public function rules(): array
    {
        return [
            'tool_ease_rating'        => 'required|integer|between:1,5',
            'tool_visual_rating'      => 'required|integer|between:1,5',
            'morris_knowledge_before' => 'required|integer|between:1,5',
            'morris_knowledge_after'  => 'required|integer|between:1,5',
            'technique_clarity'       => 'required|integer|between:1,5',
            'eco_fabric_awareness'    => 'required|integer|between:1,5',
            'app_overall_rating'      => 'required|integer|between:1,5',
            'app_usefulness'          => 'nullable|integer|between:1,5',
            'would_recommend'         => 'nullable|integer|between:1,5',
            'most_liked'              => 'nullable|string|max:1000',
            'improvement_suggestions' => 'nullable|string|max:1000',
            'design_ideas'            => 'nullable|string|max:1000',
            'time_spent_seconds'      => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'between'  => 'القيمة يجب أن تكون بين 1 و 5',
            'max'      => 'النص طويل جداً (الحد الأقصى 1000 حرف)',
        ];
    }
}
