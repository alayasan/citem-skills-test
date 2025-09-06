<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\CompanyRegistrationRequest;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class RegistrationController extends Controller
{
    /**
     * Register a new user (Step 1)
     */
    public function registerUser(UserRegistrationRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'participation_type' => $request->participation_type,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'user_id' => $user->id,
                'data' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'participation_type' => $user->participation_type,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register company information (Step 2)
     */
    public function registerCompany(CompanyRegistrationRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);

            // Handle brochure file upload
            $brochurePath = null;
            if ($request->hasFile('brochure')) {
                $brochurePath = $request->file('brochure')->store('brochures', 'public');
            }

            $company = Company::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'address_line' => $request->address_line,
                'town_city' => $request->town_city,
                'region_state' => $request->region_state,
                'country' => $request->country,
                'year_established' => $request->year_established,
                'website' => $request->website,
                'brochure_path' => $brochurePath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Company information saved successfully',
                'data' => [
                    'id' => $company->id,
                    'company_name' => $company->company_name,
                    'address_line' => $company->address_line,
                    'town_city' => $company->town_city,
                    'region_state' => $company->region_state,
                    'country' => $company->country,
                    'year_established' => $company->year_established,
                    'website' => $company->website,
                    'brochure_uploaded' => !is_null($brochurePath),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Company registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete registration (Step 3 - Final submission)
     */
    public function completeRegistration(Request $request)
    {
        try {
            $user = User::with('company')->findOrFail($request->user_id);

            if (!$user->company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Company information is required to complete registration'
                ], 400);
            }

            // Here you could add any final processing, email notifications, etc.

            return response()->json([
                'success' => true,
                'message' => 'Registration completed successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'participation_type' => $user->participation_type,
                    ],
                    'company' => [
                        'id' => $user->company->id,
                        'company_name' => $user->company->company_name,
                        'country' => $user->company->country,
                        'year_established' => $user->company->year_established,
                        'website' => $user->company->website,
                        'brochure_uploaded' => !is_null($user->company->brochure_path),
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration completion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get countries list from third-party API
     */
    public function getCountries()
    {
        try {
            // Try to fetch from external API with SSL verification disabled for development
            $response = Http::withoutVerifying()->timeout(5)->get('https://restcountries.com/v3.1/all?fields=name');

            if ($response->successful()) {
                $countries = collect($response->json())
                    ->map(function ($country) {
                        return [
                            'name' => $country['name']['common'],
                            'official' => $country['name']['official'] ?? $country['name']['common']
                        ];
                    })
                    ->sortBy('name')
                    ->values();

                return response()->json([
                    'success' => true,
                    'data' => $countries
                ]);
            }

            // Fallback if API fails
            return $this->getFallbackCountries();
        } catch (\Exception $e) {
            // Return fallback countries instead of error for better UX
            return $this->getFallbackCountries();
        }
    }

    /**
     * Get fallback countries list
     */
    private function getFallbackCountries()
    {
        $fallbackCountries = [
            ['name' => 'Afghanistan', 'official' => 'Islamic Republic of Afghanistan'],
            ['name' => 'Australia', 'official' => 'Commonwealth of Australia'],
            ['name' => 'Bangladesh', 'official' => 'People\'s Republic of Bangladesh'],
            ['name' => 'Cambodia', 'official' => 'Kingdom of Cambodia'],
            ['name' => 'Canada', 'official' => 'Canada'],
            ['name' => 'China', 'official' => 'People\'s Republic of China'],
            ['name' => 'France', 'official' => 'French Republic'],
            ['name' => 'Germany', 'official' => 'Federal Republic of Germany'],
            ['name' => 'India', 'official' => 'Republic of India'],
            ['name' => 'Indonesia', 'official' => 'Republic of Indonesia'],
            ['name' => 'Japan', 'official' => 'Japan'],
            ['name' => 'Malaysia', 'official' => 'Malaysia'],
            ['name' => 'Myanmar', 'official' => 'Republic of the Union of Myanmar'],
            ['name' => 'Philippines', 'official' => 'Republic of the Philippines'],
            ['name' => 'Singapore', 'official' => 'Republic of Singapore'],
            ['name' => 'South Korea', 'official' => 'Republic of Korea'],
            ['name' => 'Thailand', 'official' => 'Kingdom of Thailand'],
            ['name' => 'United Kingdom', 'official' => 'United Kingdom of Great Britain and Northern Ireland'],
            ['name' => 'United States', 'official' => 'United States of America'],
            ['name' => 'Vietnam', 'official' => 'Socialist Republic of Vietnam'],
        ];

        return response()->json([
            'success' => true,
            'data' => $fallbackCountries,
            'note' => 'Using fallback country list'
        ]);
    }
}
