<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY payment_method ENUM('cash', 'qris', 'ewallet', 'transfer') NULL");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::table('transactions')
                ->whereIn('payment_method', ['ewallet', 'transfer'])
                ->update(['payment_method' => 'cash']);
            DB::statement("ALTER TABLE transactions MODIFY payment_method ENUM('cash', 'qris') NULL");
        }
    }
};