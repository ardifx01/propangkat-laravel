<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'nip' => fake()->unique()->numerify('##################'), // 18 digit NIP
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'operator', 'operator-sekolah', 'pegawai']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    
    /**
     * Create an admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
    
    /**
     * Create an operator-sekolah user
     */
    public function operatorSekolah(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'operator-sekolah',
        ]);
    }
    
    /**
     * Create an operator user
     */
    public function operator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'operator',
        ]);
    }
    
    /**
     * Create a pegawai user
     */
    public function pegawai(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pegawai',
        ]);
    }
}
