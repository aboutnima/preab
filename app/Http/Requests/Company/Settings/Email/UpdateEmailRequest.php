<?php

namespace App\Http\Requests\Company\Settings\Email;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email,'.auth('company')->id()],
            'current_password' => ['required', 'string', 'current_password:company'],
        ];
    }
}
