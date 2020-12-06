<?php

namespace Database\Factories;

use App\Models\RegularAudits;
use Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegularAuditsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RegularAudits::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = Faker\Factory::create();
        return [
            'url' => $faker->url,
            'minute' => '',
            'hour' => '',
            'month_day' => '',
            'month' => '',
            'week_day' => '',
        ];
    }

    public function stars()
    {
        return $this->state(function (array $attributes) {
            return [
                'minute' => '*',
                'hour' => '*',
                'month_day' => '*',
                'month' => '*',
                'week_day' => '*',
            ];
        });
    }

    public function ranges()
    {
        return $this->state(function (array $attributes) {
            return [
                'minute' => '1-6',
                'hour' => '12-18',
                'month_day' => '5-31',
                'month' => '3-8',
                'week_day' => '1-6',
            ];
        });
    }

    public function enums()
    {
        return $this->state(function (array $attributes) {
            return [
                'minute' => '1,6',
                'hour' => '12,18',
                'month_day' => '5,31',
                'month' => '3,8',
                'week_day' => '1,6',
            ];
        });
    }

    public function periods()
    {
        return $this->state(function (array $attributes) {
            return [
                'minute' => '*/6',
                'hour' => '*/12',
                'month_day' => '*/4',
                'month' => '*/5',
                'week_day' => '*/2',
            ];
        });
    }
}
