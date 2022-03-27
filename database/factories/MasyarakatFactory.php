<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class MasyarakatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->firstName();
        $username = $name.$this->faker->numerify('###');

        return [
            'id' => $this->faker->uuid(),
            'name' => $name,
            'nik' => $this->faker->randomDigit(),
            'username' => $username,
            'password' => Hash::make($username),
            'status' => true,
        ];
    }
}
