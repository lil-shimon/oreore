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
        Schema::create('wallet_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('token_id')->constrained()->cascadeOnDelete();
            $table->decimal('available', 36, 18);
            $table->decimal('locked', 36, 18);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_tokens');
    }
};
