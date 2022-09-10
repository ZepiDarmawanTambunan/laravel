<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Diskon extends Model
{
    protected $guarded = [];

    protected $dates = ['tgl_berakhir'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
