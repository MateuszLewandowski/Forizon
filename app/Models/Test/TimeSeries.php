<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSeries extends Model
{
    protected $table = 'test_time_series';

    public $timestamps = false;

    use HasFactory;
}
