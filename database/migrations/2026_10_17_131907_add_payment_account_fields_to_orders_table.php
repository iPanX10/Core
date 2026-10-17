<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_account_number')
                ->nullable()
                ->after('payment_provider');

            $table->string('payment_account_name')
                ->nullable()
                ->after('payment_account_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_account_number',
                'payment_account_name',
            ]);
        });
    }
};