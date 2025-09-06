<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{

    /**
     * Get countries list with cities from Countries Now API
     */
    public function getCountries()
    {
        try {
            // Fetch from Countries Now API for countries with cities
            $response = Http::withoutVerifying()->timeout(10)->get('https://countriesnow.space/api/v0.1/countries');

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']) && is_array($data['data'])) {
                    $countries = collect($data['data'])
                        ->map(function ($countryData) {
                            return [
                                'name' => $countryData['country'],
                                'official' => $countryData['country'],
                                'cities' => $countryData['cities'] ?? [],
                                'iso2' => $countryData['iso2'] ?? null,
                                'iso3' => $countryData['iso3'] ?? null,
                            ];
                        })
                        ->sortBy('name')
                        ->values();

                    return response()->json([
                        'success' => true,
                        'data' => $countries,
                        'source' => 'Countries Now API'
                    ]);
                }
            }

            // Fallback if API fails
            return $this->getFallbackCountries();
        } catch (\Exception $e) {
            // Return fallback countries instead of error for better UX
            return $this->getFallbackCountries();
        }
    }

    /**
     * Get cities for a specific country
     */
    public function getCities($country)
    {
        try {
            $response = Http::withoutVerifying()->timeout(10)->post('https://countriesnow.space/api/v0.1/countries/cities', [
                'country' => $country
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']) && is_array($data['data'])) {
                    return response()->json([
                        'success' => true,
                        'data' => $data['data'],
                        'source' => 'Countries Now API'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No cities found for this country',
                'data' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities',
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Get cities for a specific state in a country
     */
    public function getCitiesByState($country, $state)
    {
        try {
            // First get all cities for the country
            $citiesResponse = Http::withoutVerifying()->timeout(10)->post('https://countriesnow.space/api/v0.1/countries/cities', [
                'country' => $country
            ]);

            if (!$citiesResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch cities',
                    'data' => []
                ]);
            }

            $citiesData = $citiesResponse->json();

            // Then get states with cities
            $statesResponse = Http::withoutVerifying()->timeout(10)->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                'country' => $country,
                'state' => $state
            ]);

            if ($statesResponse->successful()) {
                $stateData = $statesResponse->json();

                if (isset($stateData['data']) && is_array($stateData['data']) && count($stateData['data']) > 0) {
                    return response()->json([
                        'success' => true,
                        'data' => $stateData['data'],
                        'source' => 'Countries Now API - State Cities'
                    ]);
                }
            }

            // Fallback: return all cities for the country if state-specific API fails or returns empty
            if (isset($citiesData['data']) && is_array($citiesData['data'])) {
                return response()->json([
                    'success' => true,
                    'data' => $citiesData['data'],
                    'note' => 'State-specific cities not available, showing all cities for ' . $country
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No cities found for this state',
                'data' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch cities for state',
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Get states for a specific country
     */
    public function getStates($country)
    {
        try {
            $response = Http::withoutVerifying()->timeout(10)->post('https://countriesnow.space/api/v0.1/countries/states', [
                'country' => $country
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']['states']) && is_array($data['data']['states'])) {
                    $states = collect($data['data']['states'])
                        ->map(function ($state) {
                            return [
                                'name' => $state['name'],
                                'state_code' => $state['state_code'] ?? null
                            ];
                        })
                        ->sortBy('name')
                        ->values();

                    return response()->json([
                        'success' => true,
                        'data' => $states,
                        'source' => 'Countries Now API'
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No states found for this country',
                'data' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch states',
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    /**
     * Get fallback countries list with sample cities
     */
    private function getFallbackCountries()
    {
        $fallbackCountries = [
            [
                'name' => 'Afghanistan',
                'official' => 'Islamic Republic of Afghanistan',
                'cities' => ['Kabul', 'Kandahar', 'Herat', 'Mazar-i-Sharif'],
                'iso2' => 'AF',
                'iso3' => 'AFG'
            ],
            [
                'name' => 'Australia',
                'official' => 'Commonwealth of Australia',
                'cities' => ['Sydney', 'Melbourne', 'Brisbane', 'Perth', 'Adelaide', 'Canberra'],
                'iso2' => 'AU',
                'iso3' => 'AUS'
            ],
            [
                'name' => 'Philippines',
                'official' => 'Republic of the Philippines',
                'cities' => ['Manila', 'Quezon City', 'Davao', 'Cebu City', 'Zamboanga', 'Antipolo'],
                'iso2' => 'PH',
                'iso3' => 'PHL'
            ],
            [
                'name' => 'Singapore',
                'official' => 'Republic of Singapore',
                'cities' => ['Singapore'],
                'iso2' => 'SG',
                'iso3' => 'SGP'
            ],
            [
                'name' => 'United States',
                'official' => 'United States of America',
                'cities' => ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia'],
                'iso2' => 'US',
                'iso3' => 'USA'
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $fallbackCountries,
            'source' => 'Fallback country list'
        ]);
    }

    /**
     * Comprehensive registration endpoint - handles user and company creation in single transaction
     * This endpoint follows the requirements for a single comprehensive route
     */
    public function register(RegistrationRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'participation_type' => $request->participation_type,
            ]);

            // Handle brochure upload if provided
            $brochurePath = null;
            if ($request->hasFile('brochure')) {
                $brochurePath = $request->file('brochure')->store('brochures', 'public');
            }

            // Create the company
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

            DB::commit();

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
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
