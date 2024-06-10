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
        Schema::create('pay_button_models', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->string('amount');
            $table->string('currency');
            $table->string('marchantId');
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->json('metadata')->nullable();
            $table->enum('pay_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending');
            $table->json('payment_info')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_button_models');
    }
};
