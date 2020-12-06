<?php

namespace Database\Factories;

use App\Models\DesktopAudits;
use Illuminate\Database\Eloquent\Factories\Factory;
Use Faker;

class DesktopAuditsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DesktopAudits::class;

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
            'description' => $faker->words(3, true),
        ];
    }
}
