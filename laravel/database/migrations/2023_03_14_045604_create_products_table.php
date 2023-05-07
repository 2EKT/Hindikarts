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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_id');
            $table->integer('subcat_id');
            $table->integer('megacat_id');
            $table->integer('merchant_id');
            $table->integer('shop_id')->nullable();
            $table->string('title');
            $table->float('market_price')->nullable();
            $table->float('sale_price')->nullable();
            $table->string('discount_type', 20)->nullable();
            $table->float('discount')->nullable();
            $table->string('main_image');
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->string('img4')->nullable();
            $table->longText('description')->nullable();
            $table->string('colors')->nullable();
            $table->timestamps();
            $table->string('active',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};