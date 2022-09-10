<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Penjualan;
use App\Province;
use App\City;

class Pelanggan extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'pelanggan_id', 'id');
    }
}
