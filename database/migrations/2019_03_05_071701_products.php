<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id',25)->nullable();
            $table->string('title',255)->nullable();
            $table->string('base_64')->index();
            $table->mediumText('description')->nullable();
            $table->string('category',255)->nullable();
            $table->string('sku',255)->nullable();
            $table->string('price',255)->nullable();
            $table->string('discount',255)->nullable();
            $table->mediumText('img')->nullable();
            $table->mediumText('img_thumb')->nullable();
            $table->mediumText('img_small')->nullable();
            $table->mediumText('img_xs')->nullable();
            $table->string('url',500)->nullable();
            $table->string('deeplink',500)->nullable();
            $table->string('domain')->index();
            $table->enum('ads', ['active','disable']);
            $table->enum('status', ['active','disable']);
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
        Schema::dropIfExists('products');
    }
}
