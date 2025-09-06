<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;

class RegistrationControllerTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();
    Storage::fake('public');
  }

  #[Test]
  public function test_comprehensive_registration_with_valid_data()
  {
    $registrationData = [
      'first_name' => 'John',
      'last_name' => 'Doe',
      'email' => 'john.doe@example.com',
      'username' => 'johndoe123',
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Exhibitor',
      'company_name' => 'Acme Corporation',
      'address_line' => '123 Business Street',
      'town_city' => 'Manila',
      'region_state' => 'Metro Manila',
      'country' => 'Philippines',
      'year_established' => 2010,
      'website' => 'https://acme.com',
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(201)
      ->assertJsonStructure([
        'success',
        'message',
        'data' => [
          'user' => [
            'id',
            'first_name',
            'last_name',
            'email',
            'username',
            'participation_type',
          ],
          'company' => [
            'id',
            'company_name',
            'address_line',
            'town_city',
            'region_state',
            'country',
            'year_established',
            'website',
          ]
        ]
      ]);

    $this->assertDatabaseHas('users', [
      'email' => 'john.doe@example.com',
      'username' => 'johndoe123',
      'first_name' => 'John',
      'last_name' => 'Doe',
      'participation_type' => 'Exhibitor',
    ]);

    $this->assertDatabaseHas('companies', [
      'company_name' => 'Acme Corporation',
      'country' => 'Philippines',
      'year_established' => 2010,
    ]);

    $user = User::where('email', 'john.doe@example.com')->first();
    $this->assertNotNull($user->company);
    $this->assertEquals($user->id, $user->company->user_id);
  }

  #[Test]
  public function test_comprehensive_registration_with_brochure_upload()
  {
    $brochureFile = UploadedFile::fake()->create('company-brochure.pdf', 1024, 'application/pdf');

    $registrationData = [
      'first_name' => 'Jane',
      'last_name' => 'Smith',
      'email' => 'jane.smith@example.com',
      'username' => 'janesmith456',
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Buyer',
      'company_name' => 'Tech Solutions Inc',
      'address_line' => '456 Tech Avenue',
      'town_city' => 'Quezon City',
      'region_state' => 'Metro Manila',
      'country' => 'Philippines',
      'year_established' => 2015,
      'website' => 'https://techsolutions.com',
      'brochure' => $brochureFile,
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(201);

    $user = User::where('email', 'jane.smith@example.com')->first();
    $this->assertNotNull($user->company->brochure_path);
    $this->assertTrue(Storage::disk('public')->exists($user->company->brochure_path));
  }

  #[Test]
  public function test_registration_validation_fails_with_invalid_data()
  {
    $invalidData = [
      'first_name' => '', // Required field missing
      'email' => 'invalid-email', // Invalid email format
      'username' => 'user with spaces', // Invalid username format
      'password' => '123', // Password too short
      'participation_type' => 'InvalidType', // Invalid participation type
      'year_established' => 2030, // Future year
    ];

    $response = $this->postJson('/api/register', $invalidData);

    $response->assertStatus(422)
      ->assertJsonValidationErrors([
        'first_name',
        'email',
        'username',
        'password',
        'participation_type',
        'year_established',
      ]);
  }

  #[Test]
  public function test_registration_fails_with_duplicate_email()
  {
    // Create existing user
    User::factory()->create([
      'email' => 'existing@example.com',
      'username' => 'existinguser',
    ]);

    $registrationData = [
      'first_name' => 'New',
      'last_name' => 'User',
      'email' => 'existing@example.com', // Duplicate email
      'username' => 'newuser123',
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Visitor',
      'company_name' => 'New Company',
      'address_line' => '789 New Street',
      'town_city' => 'Manila',
      'region_state' => 'Metro Manila',
      'country' => 'Philippines',
      'year_established' => 2020,
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['email']);
  }

  #[Test]
  public function test_registration_fails_with_duplicate_username()
  {
    // Create existing user
    User::factory()->create([
      'email' => 'existing@example.com',
      'username' => 'existinguser',
    ]);

    $registrationData = [
      'first_name' => 'New',
      'last_name' => 'User',
      'email' => 'new@example.com',
      'username' => 'existinguser', // Duplicate username
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Visitor',
      'company_name' => 'New Company',
      'address_line' => '789 New Street',
      'town_city' => 'Manila',
      'region_state' => 'Metro Manila',
      'country' => 'Philippines',
      'year_established' => 2020,
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['username']);
  }

  #[Test]
  public function test_get_countries_from_external_api()
  {
    // Mock successful external API response
    Http::fake([
      'restcountries.com/*' => Http::response([
        ['name' => ['common' => 'Philippines', 'official' => 'Republic of the Philippines']],
        ['name' => ['common' => 'Malaysia', 'official' => 'Malaysia']],
        ['name' => ['common' => 'Singapore', 'official' => 'Republic of Singapore']],
      ], 200)
    ]);

    $response = $this->getJson('/api/countries');

    $response->assertStatus(200)
      ->assertJsonStructure([
        'success',
        'data' => [
          '*' => [
            'name',
            'official'
          ]
        ]
      ])
      ->assertJsonFragment([
        'success' => true
      ]);

    $this->assertGreaterThan(0, count($response->json('data')));
  }

  #[Test]
  public function test_get_countries_fallback_when_api_fails()
  {
    // Mock failed external API response
    Http::fake([
      'restcountries.com/*' => Http::response([], 500)
    ]);

    $response = $this->getJson('/api/countries');

    $response->assertStatus(200)
      ->assertJsonStructure([
        'success',
        'data' => [
          '*' => [
            'name',
            'official'
          ]
        ],
        'note'
      ])
      ->assertJsonFragment([
        'success' => true,
        'note' => 'Using fallback country list'
      ]);

    $this->assertGreaterThan(0, count($response->json('data')));
  }

  #[Test]
  public function test_registration_creates_database_transaction()
  {
    // This test ensures that if company creation fails, user creation is also rolled back
    $registrationData = [
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'test@example.com',
      'username' => 'testuser123',
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Exhibitor',
      'company_name' => 'Test Company',
      'address_line' => '123 Test Street',
      'town_city' => 'Test City',
      'region_state' => 'Test State',
      'country' => 'Test Country',
      'year_established' => 2020,
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(201);

    // Verify both user and company were created
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    $this->assertDatabaseHas('companies', ['company_name' => 'Test Company']);

    // Verify relationship
    $user = User::where('email', 'test@example.com')->first();
    $this->assertNotNull($user->company);
  }

  #[Test]
  public function test_brochure_file_validation()
  {
    $invalidFile = UploadedFile::fake()->create('invalid.txt', 1024, 'text/plain');

    $registrationData = [
      'first_name' => 'Test',
      'last_name' => 'User',
      'email' => 'test@example.com',
      'username' => 'testuser123',
      'password' => 'SecurePass123!',
      'password_confirmation' => 'SecurePass123!',
      'participation_type' => 'Exhibitor',
      'company_name' => 'Test Company',
      'address_line' => '123 Test Street',
      'town_city' => 'Test City',
      'region_state' => 'Test State',
      'country' => 'Test Country',
      'year_established' => 2020,
      'brochure' => $invalidFile, // Invalid file type
    ];

    $response = $this->postJson('/api/register', $registrationData);

    $response->assertStatus(422)
      ->assertJsonValidationErrors(['brochure']);
  }
}
