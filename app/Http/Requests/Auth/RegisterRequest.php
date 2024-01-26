<?php

namespace App\Http\Requests\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Admin;
use App\Models\Doctor;

class RegisterRequest extends FormRequest
{
    use PasswordValidationRules;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique(User::class,'email'),
                Rule::unique(Admin::class,'email'),
                Rule::unique(Doctor::class,'email'),
                Rule::unique(Pharmacy::class,'email'),
            ],
            'password' => $this->passwordRules(),
            'phone_number' => [
                'required', 'string', 'max:15',
                Rule::unique(User::class),
                Rule::unique(Admin::class),
                Rule::unique(Doctor::class),
                Rule::unique(Pharmacy::class),
            ],
            "device_name" => "string|max:255",
            'user_type' => "required|integer",
        ];
    }
}
