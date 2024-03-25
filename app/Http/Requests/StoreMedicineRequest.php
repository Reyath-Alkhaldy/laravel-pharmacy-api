<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
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
        // 'name_en', 'name_ar', 'scien_name', 'mark_name', 'image',
        // 'price', 'discount', 'count', 'status', 'description', 
        // 'sub_category_id', 'pharmacy_id'
        return [
            "name_en" => "required|string|min:3|max:255",
            "name_ar" => "required|string|min:3|max:255",
            "scien_name" => "sometimes|string|min:3|max:255",
            "mark_name" => "sometimes|string|min:3|max:255",
            "count" => "required|integer",
            "price" => "required",
            "discount" => "sometimes|required",
            'image'=>['sometimes'],
            // 'image'=>['sometimes','max:104800000|dimensions:max_width=10000,max_height=10000'],
            'status'=>'in:active,inactive',
            'description' => "sometimes|string|min:3|max:255",
            "sub_category_id" => "required|integer", 
        ];
    }
}
