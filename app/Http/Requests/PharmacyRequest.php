<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyRequest extends FormRequest
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
        // {{-- $table->string('name');
        //     $table->string('password');
        //     $table->string('address');
        //     $table->string('phone_number')->unique();
        //     $table->string('logo_image');
        //     $table->enum('status',['active','inactive'])->default('inactive');
        //     $table->string('number_of_view_days')->nullable(); --}}
        return [
            "name" => "required|string|min:3|max:255",
            "password" => "required|string|min:3|max:255",
            "address" => "required|string|min:3|max:255",
            "phone_number" => "required|integer|unique:pharmacies,phone_number",
            'logo_image'=>'max:104800000|dimensions:max_width=10000,max_height=10000',
            'status'=>'in:active,inactive',
            'number_of_view_days' => "required|integer"
        ];
    }
}
