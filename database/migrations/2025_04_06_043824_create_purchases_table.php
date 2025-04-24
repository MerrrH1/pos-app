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
        Schema::create('purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->primary();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers');
            $table->timestamp('date');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
