<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => User::factory(),
      'company_name' => fake()->company(),
      'address_line' => fake()->streetAddress(),
      'town_city' => fake()->city(),
      'region_state' => fake()->state(),
      'country' => fake()->country(),
      'year_established' => fake()->numberBetween(1900, date('Y')),
      'website' => fake()->optional()->url(),
      'brochure_path' => null,
    ];
  }
}
