<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Produk;

class Keranjang extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
