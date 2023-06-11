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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->integer('zone_partner_id');
            $table->integer('district_partner_id');
            $table->integer('block_partner_id');
            $table->integer('employer_id');
            $table->integer('merchant_type_id');
            $table->string('name',100);
            $table->string('email',100);
            $table->string('phone',20);
            $table->string('password',200);
            $table->string('remember_token',100)->nullable();
            $table->string('image',100);
            $table->string('active_status',20);
            $table->float('wallet_balance',10,2);
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
        Schema::dropIfExists('merchants');
    }
};