<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegistrationRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'company_name' => 'required|string|max:255',
            'address_line' => 'required|string|max:500',
            'town_city' => 'required|string|max:255',
            'region_state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'year_established' => 'required|integer|min:1800|max:' . date('Y'),
            'website' => 'nullable|url|max:255',
            'brochure' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'year_established.min' => 'Year established must be after 1800.',
            'year_established.max' => 'Year established cannot be in the future.',
            'website.url' => 'Please enter a valid website URL.',
            'brochure.mimes' => 'Company brochure must be a PDF file.',
            'brochure.max' => 'Company brochure file size cannot exceed 5MB.',
        ];
    }
}
