<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'registered_by' => ['required', 'in:father,mother'], // Match DB enum/check constraint
            'mobile' => ['required', 'string', 'max:20'],
            
            'father_name' => ['required_unless:registered_by,father', 'nullable', 'string', 'max:255'],
            'father_mobile' => ['required_unless:registered_by,father', 'nullable', 'string', 'max:20'],
            'father_job' => ['nullable', 'string', 'max:255'],

            'mother_name' => ['required_unless:registered_by,mother', 'nullable', 'string', 'max:255'],
            'mother_mobile' => ['required_unless:registered_by,mother', 'nullable', 'string', 'max:20'],
            'mother_job' => ['nullable', 'string', 'max:255'],

            'address' => ['required', 'string', 'max:500'],
            'ideal_community_opinion' => ['nullable', 'string'],
            // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            'password' => ['required', 'confirmed', 'min:8', ],
        ];
    }

    public function messages(): array
    {
        return [
            'father_name.required_unless' => 'يرجى إدخال اسم الأب.',
            'father_mobile.required_unless' => 'يرجى إدخال رقم هاتف الأب.',
            'mother_name.required_unless' => 'يرجى إدخال اسم الأم.',
            'mother_mobile.required_unless' => 'يرجى إدخال رقم هاتف الأم.',
            'password.regex' => 'يجب أن تحتوي كلمة المرور على حرف كبير، حرف صغير، رقم، ورمز خاص.',
        ];
    }
}