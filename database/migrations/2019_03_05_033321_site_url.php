<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_url', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain',255)->nullable();
            $table->string('total',25)->nullable();
            $table->string('per_page',25)->nullable();
            $table->string('page',25)->nullable();
            $table->string('limit_page',25)->nullable();
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
        Schema::dropIfExists('site_url');
    }
}
