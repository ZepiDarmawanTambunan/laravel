<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualan;
use App\Produk;

class PenjualanDetail extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    protected $table = 'penjualan_details';

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
