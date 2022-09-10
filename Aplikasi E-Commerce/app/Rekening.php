<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pemilik;
use App\Pembayaran;

class Rekening extends Model
{
    protected $guarded = [];

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'rekening_id', 'id');
    }
}
