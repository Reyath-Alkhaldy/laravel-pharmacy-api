<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Admin;
use App\Models\Doctor;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes', 'string', 'email', 'max:255',
            ],
            'phone_number' => [
                'sometimes', 'string', 'max:15',
            ],
            'image' => ['image', 'max:4096'],
            'user_type' => "required|integer",
            'specialty_id' => "sometimes|string|max:255",

        ];
    }
}
