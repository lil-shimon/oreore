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
        Schema::table('wallet_tokens', function (Blueprint $table) {
            $table->decimal('usdt_value', 36, 18)->default(0)->after('locked');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_tokens', function (Blueprint $table) {
            $table->dropColumn('usdt_value');
        });
    }
};
