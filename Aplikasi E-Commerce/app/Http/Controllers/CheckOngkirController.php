<?php

namespace App\Http\Controllers;

use App\City;
use App\Province;
use App\Courier;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Http\Request;

class CheckOngkirController extends Controller
{
    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);
    }

    public function getOngkir($data)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten asal
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        return json_encode($cost);
    }
}
