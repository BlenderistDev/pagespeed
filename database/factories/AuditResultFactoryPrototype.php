<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

abstract class AuditResultFactoryPrototype extends Factory
{
    public function value($value): self
    {
        return $this->state(function (array $attributes) use ($value) {
            return [
                'value' => $value,
            ];
        });
    }

    public function measurement(int $measurementId): self
    {
        return $this->state(function (array $attributes) use ($measurementId) {
            return [
                'measurements_id' => $measurementId,
            ];
        });
    }

    public function audit(int $auditId): self
    {
        return $this->state(function (array $attributes) use ($auditId) {
            return [
                'audits_id' => $auditId,
            ];
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $faker = Faker\Factory::create();
        return [
            'audits_id' => 0,
            'value' => $faker->randomDigit,
            'measurements_id' => 0,
        ];
    }
}
