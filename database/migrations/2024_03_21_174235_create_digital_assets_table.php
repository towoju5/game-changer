<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('digital_assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->string('price', 191)->nullable();
            $table->string('quantity', 191)->nullable();
            $table->boolean('exchangeable')->default(0);
            $table->boolean('giftable')->default(0);
            $table->string('free_rubies', 191)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_assets');
    }
};
