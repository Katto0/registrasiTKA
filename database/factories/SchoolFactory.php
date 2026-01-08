<?php

namespace Database\Factories;

use App\Models\Operator;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operator_id' => Operator::factory(),
            'nama_sekolah' => $this->faker->company . ' School',
            'npsn_sekolah' => $this->faker->unique()->numerify('########'),
            'jenjang_pendidikan' => $this->faker->randomElement(['SD', 'SMP']),
            'jumlah_perangkat' => $this->faker->numberBetween(10, 50),
        ];
    }
}
