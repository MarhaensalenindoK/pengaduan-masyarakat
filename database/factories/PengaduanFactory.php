<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['done', 'inprogress', 'todo'];

        return [
            'id' => $this->faker->uuid(),
            'nik' => $this->faker->randomNumber(),
            'content' => $this->faker->text(),
            'photo' => null,
            'status' => $this->faker->randomElement($status),
        ];
    }
}
