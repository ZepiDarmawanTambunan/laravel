<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Rekening;
use App\Province;
use App\City;

class Pemilik extends Model
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

    protected function rekening()
    {
        return $this->hasMany(Rekening::class, 'pemilik_id', 'id');
    }
}
