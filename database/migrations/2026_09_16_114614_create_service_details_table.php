<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('mechanic_id')->constrained('users')->cascadeOnDelete();
            $table->text('inspection')->nullable()->comment('Hasil pemeriksaan kendaraan');
            $table->text('work_description')->nullable()->comment('Deskripsi pekerjaan yang dilakukan');
            $table->text('sparepart_used')->nullable()->comment('Sparepart yang digunakan (JSON atau text)');
            $table->decimal('service_cost', 12, 2)->default(0)->comment('Biaya servis tambahan');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};