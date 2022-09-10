<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Pelanggan;
use App\Admin;
use App\Pemilik;
use App\Produk;
use App\Keranjang;
use App\Penjualan;
use App\Pembayaran;
use App\Diskon;
use App\Beranda;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'email', 'password', 'akses', 'image', 'no_hp', 'alamat',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'user_id', 'id');
    }

    protected function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    protected function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'user_id', 'id');
    }

    protected function produk()
    {
        return $this->hasMany(Produk::class, 'user_id', 'id');
    }

    protected function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id', 'id');
    }

    protected function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'id');
    }

    protected function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'user_id', 'id');
    }

    protected function diskon()
    {
        return $this->hasMany(Diskon::class, 'user_id', 'id');
    }

    protected function beranda()
    {
        return $this->hasMany(Beranda::class, 'user_id', 'id');
    }
}
