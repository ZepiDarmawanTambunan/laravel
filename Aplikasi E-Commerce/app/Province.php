<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pelanggan;
use App\Pemilik;
use App\Pengiriman;

class Province extends Model
{
    protected $guarded = [];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'province_id', 'province_id');
    }

    public function pemilik()
    {
        return $this->hasMany(Pemilik::class, 'province_id', 'province_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'province_id', 'province_id');
    }
}
