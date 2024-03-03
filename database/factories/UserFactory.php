<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'instance_id' => $this->faker->uuid(),
            'aud' => $this->faker->word(),
            'role' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'encrypted_password' => $this->faker->password(),
            'email_confirmed_at' => Carbon::now(),
            'invited_at' => Carbon::now(),
            'confirmation_token' => Str::random(10),
            'confirmation_sent_at' => Carbon::now(),
            'recovery_token' => Str::random(10),
            'recovery_sent_at' => Carbon::now(),
            'email_change_token_new' => $this->faker->unique()->safeEmail(),
            'email_change' => $this->faker->unique()->safeEmail(),
            'email_change_sent_at' => Carbon::now(),
            'last_sign_in_at' => Carbon::now(),
            'raw_app_meta_data' => [],
            'raw_user_meta_data' => [],
            'is_super_admin' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'phone' => $this->faker->phoneNumber(),
            'phone_confirmed_at' => Carbon::now(),
            'phone_change' => $this->faker->phoneNumber(),
            'phone_change_token' => $this->faker->phoneNumber(),
            'phone_change_sent_at' => Carbon::now(),
            'confirmed_at' => Carbon::now(),
            'email_change_token_current' => $this->faker->unique()->safeEmail(),
            'email_change_confirm_status' => $this->faker->numberBetween(1, 2),
            'banned_until' => Carbon::now(),
            'reauthentication_token' => Str::random(10),
            'reauthentication_sent_at' => Carbon::now(),
            'is_sso_user' => $this->faker->boolean(),
            'deleted_at' => Carbon::now(),
        ];
    }
}
