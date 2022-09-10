<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Pelanggan;
use App\PenjualanDetail;
use App\Pengiriman;
use App\Pembayaran;

class Penjualan extends Model
{
    protected $guarded = [];

    protected function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'penjualan_id', 'id');
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'penjualan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

}
