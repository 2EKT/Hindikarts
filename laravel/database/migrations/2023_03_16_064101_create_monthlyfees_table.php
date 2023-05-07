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
        Schema::create('monthlyfees', function (Blueprint $table) {
            $table->id();
            $table->float('zone_reg');
            $table->float('zone_monthly');
            $table->float('district_reg');
            $table->float('district_monthly');
            $table->float('block_reg');
            $table->float('block_monthly');
            $table->float('employee_reg');
            $table->float('employee_monthly');
            $table->float('delivery_boy_reg');
            $table->float('delivery_boy_monthly');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthlyfees');
    }
};