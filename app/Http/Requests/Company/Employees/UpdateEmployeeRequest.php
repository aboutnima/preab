<?php

namespace App\Http\Requests\Company\Employees;

use App\Enums\GenderEnum;
use App\Models\Employee;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Employee $employee */
        $employee = $this->route('employee');

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('employees', 'email')->ignore($employee->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'gender' => ['nullable', Rule::enum(GenderEnum::class)],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('employees', 'username')->ignore($employee->id)],
            'bio' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
        ];
    }
}
