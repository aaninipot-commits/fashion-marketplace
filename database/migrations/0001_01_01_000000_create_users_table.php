<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->string('role', 191)->default('user'); // user, admin/seller
            $table->string('phone', 191)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('shop_name', 191)->nullable(); // for sellers
            $table->string('shop_description', 191)->nullable(); // for sellers
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};