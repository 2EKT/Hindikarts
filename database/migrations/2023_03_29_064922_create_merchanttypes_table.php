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
        Schema::create('merchanttypes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_id');
            $table->string('type');
            $table->string('slug');
            $table->float('registration_fee');
            $table->float('monthly_fee');
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
        Schema::dropIfExists('merchanttypes');
    }
};
