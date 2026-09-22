<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $table = 'service_details';

    protected $fillable = [
        'booking_id',
        'inspection',
        'work_description',
        'sparepart_used',
        'service_cost',
        'notes',
    ];

    protected $casts = [
        'service_cost' => 'decimal:2',
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

}