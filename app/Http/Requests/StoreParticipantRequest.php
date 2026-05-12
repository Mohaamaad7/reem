<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('admin_logged_in');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المشارك مطلوب',
            'name.min'      => 'الاسم يجب أن يكون حرفين على الأقل',
            'name.max'      => 'الاسم طويل جداً',
        ];
    }
}
