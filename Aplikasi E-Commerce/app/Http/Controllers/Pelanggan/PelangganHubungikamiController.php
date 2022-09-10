<?php


namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;

class PelangganHubungikamiController extends Controller
{
    public function form()
    {
        return view('pelanggan.pelanggan_hubungikami_form');
    }
}
