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
        Schema::create('districtpartners', function (Blueprint $table) {
            $table->id();
            $table->integer('zone_partner_id');
            $table->integer('district_id',11);
            $table->string('name',100);
            $table->string('email',100);
            $table->string('phone',20);
            $table->string('password',200);
            $table->string('image',100);
            $table->string('active_status',20);
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
        Schema::dropIfExists('districtpartners');
    }
};