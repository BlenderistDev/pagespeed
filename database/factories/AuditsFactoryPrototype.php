<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
Use Faker;

class AuditsFactoryPrototype extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create();
        return [
            'name' => $faker->word(),
            'title' => $faker->word(),
            'description' => $faker->words(3, true),
        ];
    }
}
