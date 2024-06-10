<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('username', 191)->nullable()->unique();
            $table->decimal('balance', 28,8)->default(0.00);
            $table->string('email', 191)->nullable()->unique();
            $table->timestamp('last_login')->useCurrent();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('account_verification', 191)->nullable()->default('Under Review');
            $table->string('password')->nullable();
            $table->string('profile_picture', 191)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}