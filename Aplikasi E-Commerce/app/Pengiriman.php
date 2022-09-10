<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualan;
use App\Province;
use App\City;

class Pengiriman extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    public $table = "pengirimans";

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
