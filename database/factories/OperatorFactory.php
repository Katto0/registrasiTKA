<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_operator' => $this->faker->name,
            'no_whatsapp' => $this->faker->phoneNumber,
            'email_sekolah' => $this->faker->unique()->safeEmail,
        ];
    }
}
