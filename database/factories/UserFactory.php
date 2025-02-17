<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

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
        $name = $this->faker->name();
        // Generate a username from the name
        $baseUsername = Str::lower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        $username = $baseUsername . random_int(100, 999);

        return [
            'name' => $name,
            'username' => $username,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= bcrypt('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withTeam(callable $callback = null): static
    {
        return $this->afterCreating(function (User $user) use ($callback) {
            $team = Team::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Team",
                'personal_team' => true,
            ]);

            $user->update(['current_team_id' => $team->id]);

            if ($callback) {
                $callback($team, $user);
            }
        });
    }
}
