<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 191);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image', 191)->nullable();
            $table->string('size', 191)->nullable();
            $table->string('color', 191)->nullable();
            $table->integer('stock')->default(0);
            $table->string('status', 191)->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};