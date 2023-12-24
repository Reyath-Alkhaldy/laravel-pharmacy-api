<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicineRequest extends FormRequest
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
        // $table->string('name_en');
    // $table->string('name_ar');
    // $table->string('image');
    // $table->double('price');
    // $table->string('description')->nullable();
    // $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();
    // $table->foreignId('pharmacy_id')->constrained('pharmacies')->cascadeOnDelete();
        return [
            "name_en" => "required|string|min:3|max:255",
            "name_ar" => "required|string|min:3|max:255",
            "count" => "required|integer",
            "price" => "required",
            'image'=>'max:104800000|dimensions:max_width=10000,max_height=10000',
            'status'=>'in:active,inactive',
            'description' => "required|string|min:3|max:255",
            "sub_category_id" => "required",
            "pharmacy_id" => "required",
        ];
    }
}
