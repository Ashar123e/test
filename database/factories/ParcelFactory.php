<?php

namespace Database\Factories;

use App\Models\Parcel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parcel>
 */
class ParcelFactory extends Factory
{
    protected $model = Parcel::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'weight' => fake()->randomFloat('2', 0, 2),
            'amount' => fake()->randomFloat('2', 0 ,2),
            'status' => 'Pending', // password
        ];
    }
}
