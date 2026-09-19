<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plate_number',
        'brand',
        'model',
        'year',
        'color',
    ];

    protected $casts = [
        'year' => 'integer',
    ];

    // Relasi ke user (pemilik kendaraan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }

    // Helper: nama lengkap kendaraan
    public function getFullAttribute()
    {
        return $this->brand . ' ' . $this->model . ' (' . $this->plate_number . ')';
    }
}