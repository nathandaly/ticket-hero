<?php

namespace Database\Factories;

use App\Models\Hero;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Hero> */
class HeroFactory extends Factory
{
    protected $model = Hero::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->name(),
        ];
    }
}
