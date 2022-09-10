<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Penjualan;
use App\Rekening;
use App\User;

class Pembayaran extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function penjualan()
    {
        // untuk pelanggan
        return $this->belongsTo(Penjualan::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    public function user()
    {
        // untuk admin dan pemilik
        return $this->belongsTo(User::class);
    }
}
