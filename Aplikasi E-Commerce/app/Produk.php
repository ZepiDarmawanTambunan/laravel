<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Keranjang;
use App\User;
use App\PenjualanDetail;

class Produk extends Model
{
    protected $guarded = [];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'produk_id', 'id');
    }

    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'produk_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
