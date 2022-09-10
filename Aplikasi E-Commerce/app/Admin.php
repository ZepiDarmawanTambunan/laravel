<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Admin extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
