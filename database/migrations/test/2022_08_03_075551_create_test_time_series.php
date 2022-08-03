<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_time_series', function (Blueprint $table) {
            $table->id();

            $table->date('key_1')->nullable();
            $table->dateTime('key_2')->nullable();
            $table->time('key_3')->nullable();
            $table->integer('key_4')->nullable();

            $table->integer('value_1')->nullable();
            $table->integer('value_2')->nullable();
            $table->float('value_3', 16)->nullable();
            $table->float('value_4', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_time_series');
    }
};
