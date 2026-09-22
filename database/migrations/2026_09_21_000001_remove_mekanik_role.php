<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('bookings', 'mechanic_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropForeign(['mechanic_id']);
                $table->dropColumn('mechanic_id');
            });
        }

        if (Schema::hasColumn('service_details', 'mechanic_id')) {
            Schema::table('service_details', function (Blueprint $table) {
                $table->dropForeign(['mechanic_id']);
                $table->dropColumn('mechanic_id');
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'mekanik')->update(['role' => 'admin']);
            DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'admin', 'kasir') NOT NULL DEFAULT 'customer'");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'mechanic_id')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->foreignId('mechanic_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }

        if (Schema::hasTable('service_details') && !Schema::hasColumn('service_details', 'mechanic_id')) {
            Schema::table('service_details', function (Blueprint $table) {
                $table->foreignId('mechanic_id')->nullable()->constrained('users')->nullOnDelete();
            });
        }

        if (DB::getDriverName() === 'mysql' && Schema::hasColumn('users', 'role')) {
            DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'admin', 'mekanik', 'kasir') NOT NULL DEFAULT 'customer'");
        }
    }
};
