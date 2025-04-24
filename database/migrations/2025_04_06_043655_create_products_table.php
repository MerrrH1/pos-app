<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->primary();
            $table->string('name', 255)->unique();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('unit_id')->references('id')->on('units');
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
