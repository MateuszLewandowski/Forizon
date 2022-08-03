<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Test\TimeSeries as TimeSeriesModel;
use Illuminate\Database\Seeder;

class TimeSeries extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        TimeSeriesModel::factory(1000)->create();
    }
}
