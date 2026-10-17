<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'payment_account_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_account_number')
                    ->nullable()
                    ->after('payment_provider');
            });
        }

        if (!Schema::hasColumn('orders', 'payment_account_name')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_account_name')
                    ->nullable()
                    ->after('payment_account_number');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'payment_account_name')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_account_name');
            });
        }

        if (Schema::hasColumn('orders', 'payment_account_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('payment_account_number');
            });
        }
    }
};