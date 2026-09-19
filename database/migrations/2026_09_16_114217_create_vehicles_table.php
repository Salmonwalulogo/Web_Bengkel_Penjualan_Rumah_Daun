<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plate_number')->comment('Nomor plat kendaraan');
            $table->string('brand')->comment('Merek, contoh: Honda, Toyota');
            $table->string('model')->comment('Model, contoh: Vario, Avanza');
            $table->year('year')->nullable()->comment('Tahun produksi');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};