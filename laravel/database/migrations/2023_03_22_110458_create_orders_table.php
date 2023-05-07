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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('delivery_boy_id')->nullable();
            $table->bigInteger('delivery_address_id');
            $table->longText('delivery_address')->nullable();
            $table->longText('pickup_address')->nullable();
            $table->string('landmark')->nullable();;
            $table->string('delivery_name')->nullable();
            $table->string('order_no', 50)->nullable();
            $table->string('invoice')->nullable();
            $table->string('payment_type', 20)->nullable();
            $table->decimal('sub_total',8,2)->nullable();
            $table->decimal('discount_amount',8,2)->nullable();
            $table->decimal('delivery_charge',8,2)->nullable();
            $table->decimal('total_amount',8,2)->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->string('status', 30);
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
        Schema::dropIfExists('orders');
    }
};
