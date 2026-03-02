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
        Schema::create('payments_logs', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->json('payload')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_logs');
    }
};
