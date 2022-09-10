<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Keranjang as Model;
use App\Produk;
use App\Diskon;
use App\Province;
use App\Courier;


class PelangganKeranjangController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $authPelanggan = $auth->pelanggan;
        $data['model'] = Model::where('user_id', $auth->id)->get();
        $data['provinces'] = Province::pluck('title', 'province_id');
        $data['province_id'] = $authPelanggan->province_id;
        $data['couriers'] = Courier::pluck('title', 'code');
        $data['city_id'] = $auth->city_id;

        return view('pelanggan.pelanggan_keranjang_index', $data);
    }

    public function getModel()
    {
        $model = Model::where('user_id', Auth::user()->id)->get();
        return response()->json($model);
    }

    public function store($id)
    {
        $produk = Produk::where('id', $id)->first();
        $authId = Auth::user()->id;

        if($produk == null){
            toast('Error invalid', 'error');
            return back();
        }

        // jika stok produk <= 0
        if($produk->jumlah <= 0){
            toast('Stok Habis', 'error');
            return back();
        }

        $keranjang = Model::where('user_id', $authId)->where('produk_id', $id)->first();

        if(isset($keranjang)){
            $keranjang->update([
                'jumlah' => $keranjang->jumlah +1,
            ]);

            toast('Data berhasil ditambah', 'success');
            return back();
        }

        $data['model'] = Model::create([
            'user_id' => $authId,
            'produk_id' => $produk->id,
            'jumlah' => '1',
        ]);

        toast('Data berhasil ditambah', 'success');
        return back();
    }

    public function plus($id){
        $model = Model::where('id', $id)->first();
        
        if($model == null){
            return response()->json('error');
        }

        if($model->jumlah >= $model->produk->jumlah){
            return response()->json('stok_penuh');
        }

        $model->update([
            'jumlah' => $model->jumlah +1,
        ]);

        return response()->json($model);
    }

    public function minus($id){
        $model = Model::where('id', $id)->with('produk')->first();

        if($model == null){
            return response()->json('error');
        }

        if($model->jumlah == 1){
            $model->delete();
            return response()->json('0');
        }

        $model->update([
            'jumlah' => $model->jumlah -1,
        ]);

        return response()->json($model);
    }
}
