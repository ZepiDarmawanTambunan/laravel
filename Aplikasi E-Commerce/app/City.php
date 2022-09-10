<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pelanggan;
use App\Pemilik;
use App\Pengiriman;

class City extends Model
{
    protected $guarded = [];

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'city_id', 'city_id');
    }

    public function pemilik()
    {
        return $this->hasMany(Pemilik::class, 'city_id', 'city_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'city_id', 'city_id');
    }
}
