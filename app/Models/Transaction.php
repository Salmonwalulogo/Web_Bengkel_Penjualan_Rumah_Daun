<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_payment',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'total_payment' => 'decimal:2',
    ];

    // Auto generate invoice number saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->invoice_number)) {
                $transaction->invoice_number = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }

    // ============ RELASI ============

    // User/customer
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Detail transaksi (produk yang dibeli)
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

    // Pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class, 'transaction_id');
    }

    // ============ HELPER ============

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning text-dark',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'cash' => 'Tunai',
            'qris' => 'QRIS',
                'ewallet' => 'E-Wallet',
                'transfer' => 'Transfer Bank',
            default => ucfirst($this->payment_method),
        };
    }
}