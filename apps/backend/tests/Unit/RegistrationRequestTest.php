<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RegistrationRequestTest extends TestCase
{
  use RefreshDatabase;
  #[Test]
  public function test_registration_request_validation_passes_with_valid_data()
  {
    $request = new RegistrationRequest();

    $validData = [
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

    $validator = Validator::make($validData, $request->rules());

    $this->assertTrue($validator->passes());
    $this->assertEmpty($validator->errors()->all());
  }

  #[Test]
  public function test_registration_request_requires_first_name()
  {
    $request = new RegistrationRequest();

    $data = [
      'first_name' => '', // Empty first name
      'last_name' => 'Doe',
      'email' => 'john.doe@example.com',
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('first_name', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_email_format()
  {
    $request = new RegistrationRequest();

    $data = [
      'first_name' => 'John',
      'last_name' => 'Doe',
      'email' => 'invalid-email-format', // Invalid email
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('email', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_username_alphanumeric()
  {
    $request = new RegistrationRequest();

    $data = [
      'username' => 'user with spaces!@#', // Invalid username with spaces and special chars
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('username', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_password_length()
  {
    $request = new RegistrationRequest();

    $data = [
      'password' => '123', // Too short
      'password_confirmation' => '123',
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('password', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_password_confirmation()
  {
    $request = new RegistrationRequest();

    $data = [
      'password' => 'SecurePass123!',
      'password_confirmation' => 'DifferentPassword123!', // Not matching
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('password', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_participation_type()
  {
    $request = new RegistrationRequest();

    $data = [
      'participation_type' => 'InvalidType', // Invalid participation type
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('participation_type', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_accepts_valid_participation_types()
  {
    $request = new RegistrationRequest();

    $validTypes = ['Buyer', 'Exhibitor', 'Visitor'];

    foreach ($validTypes as $type) {
      $data = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'username' => 'johndoe123',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'participation_type' => $type,
        'company_name' => 'Acme Corporation',
        'address_line' => '123 Business Street',
        'town_city' => 'Manila',
        'region_state' => 'Metro Manila',
        'country' => 'Philippines',
        'year_established' => 2010,
      ];

      $validator = Validator::make($data, $request->rules());

      $this->assertTrue($validator->passes(), "Failed for participation type: {$type}");
    }
  }

  #[Test]
  public function test_registration_request_validates_year_established()
  {
    $request = new RegistrationRequest();

    $data = [
      'year_established' => 2030, // Future year
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('year_established', $validator->errors()->toArray());

    // Test with year too old
    $data['year_established'] = 1799;
    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('year_established', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_validates_website_url()
  {
    $request = new RegistrationRequest();

    $data = [
      'website' => 'not-a-valid-url', // Invalid URL
    ];

    $validator = Validator::make($data, $request->rules());

    $this->assertTrue($validator->fails());
    $this->assertArrayHasKey('website', $validator->errors()->toArray());
  }

  #[Test]
  public function test_registration_request_website_is_optional()
  {
    $request = new RegistrationRequest();

    $validData = [
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
      // website is not provided - should be optional
    ];

    $validator = Validator::make($validData, $request->rules());

    $this->assertTrue($validator->passes());
  }

  #[Test]
  public function test_authorization_returns_true()
  {
    $request = new RegistrationRequest();

    $this->assertTrue($request->authorize());
  }
}
