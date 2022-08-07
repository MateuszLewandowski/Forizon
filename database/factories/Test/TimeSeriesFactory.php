<?php

namespace Database\Factories\Test;

use App\Models\Test\TimeSeries;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test\TimeSeries>
 */
class TimeSeriesFactory extends Factory
{
    use WithFaker;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeSeries::class;

    /**
     * Define the model's default state.
     *
     * @see https://github.com/fzaninotto/Faker#fakerproviderbase
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'key_1' => $faker->date(),
            'key_2' => $faker->dateTimeBetween(startDate: '-1 years', endDate: 'now')->format('Y-m-d H:i:s'),
            'key_3' => $faker->time(),
            'key_4' => $faker->randomDigitNotNull(),

            'value_1' => $faker->randomNumber(8),
            'value_2' => $faker->randomNumber(4),
            'value_3' => $faker->randomFloat(2, 1e8, 9e8),
            'value_4' => $faker->randomFloat(2, 1e4, 9e4),
        ];
    }
}
