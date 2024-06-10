<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('key', 191)->nullable()->default('0');
            $table->string('value', 191)->nullable()->default('0');
            $table->string('balance', 191)->nullable()->default('0');
            $table->string('diamonds', 191)->nullable()->default('0');
            $table->string('rubies', 191)->nullable()->default('0');
            $table->string('coins', 191)->nullable()->default('0');
            $table->string('rocks', 191)->nullable()->default('0');
            $table->string('teddy_bears', 191)->nullable()->default('0');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_wallets');
    }
};
