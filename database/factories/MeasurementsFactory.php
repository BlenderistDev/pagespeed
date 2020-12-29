<?php

namespace Database\Factories;

use App\Models\Measurements;
use Illuminate\Database\Eloquent\Factories\Factory;
Use Faker;

class MeasurementsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Measurements::class;

    public function domain(string $domain): self
    {
        return $this->state(function (array $attributes) use ($domain) {
            return [
                'domain' => $domain,
            ];
        });
    }

    public function comment(string $comment): self
    {
        return $this->state(function (array $attributes) use ($comment) {
            return [
                'comment' => $comment,
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create();
        return [
            'domain' => $faker->url,
            'comment' => $faker->words(3, true),
        ];
    }
}
