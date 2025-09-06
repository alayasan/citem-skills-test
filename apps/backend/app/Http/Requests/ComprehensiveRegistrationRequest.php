<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComprehensiveRegistrationRequest extends FormRequest
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
      // Step 1: Account Information
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email|max:255',
      'username' => 'required|string|alpha_num|unique:users,username|max:255',
      'password' => 'required|string|min:8|confirmed',
      'password_confirmation' => 'required|string|min:8',
      'participation_type' => ['required', Rule::in(['Buyer', 'Exhibitor', 'Visitor'])],

      // Step 2: Company Information
      'company_name' => 'required|string|max:255',
      'address_line' => 'required|string|max:500',
      'town_city' => 'required|string|max:255',
      'region_state' => 'required|string|max:255',
      'country' => 'required|string|max:255',
      'year_established' => 'required|integer|min:1800|max:' . date('Y'),
      'website' => 'nullable|url|max:255',
      'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // 2MB max
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
      'email.unique' => 'This email address is already registered.',
      'username.unique' => 'This username is already taken.',
      'username.alpha_num' => 'Username must contain only letters and numbers.',
      'password.min' => 'Password must be at least 8 characters long.',
      'password.confirmed' => 'Password confirmation does not match.',
      'participation_type.in' => 'Please select a valid participation type.',
      'year_established.min' => 'Year established must be 1800 or later.',
      'year_established.max' => 'Year established cannot be in the future.',
      'brochure.mimes' => 'Brochure must be a PDF, DOC, or DOCX file.',
      'brochure.max' => 'Brochure file size must not exceed 2MB.',
    ];
  }
}
