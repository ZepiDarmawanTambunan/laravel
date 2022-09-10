<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\User;

class PelangganTentangkamiController extends Controller
{
    public function index()
    {
        $data['model'] = User::where('akses', 'pemilik')->first();
        return view('pelanggan.pelanggan_tentangkami', $data);
    }
}
