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
        Schema::create('delivery_boys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone',15);
            $table->string('father_name')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('lang')->nullable();
            $table->decimal('wallet_balance', 10,2)->nullable();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->string('active_status',10)->nullable();
            $table->text('current_lat')->nullable();
            $table->text('current_long')->nullable();
            $table->text('duty_status',10)->nullable();
            $table->text('device_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('delivery_boys');
    }
};
