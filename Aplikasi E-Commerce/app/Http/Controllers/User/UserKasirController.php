<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Keranjang as Model;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserKasirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::where('user_id', Auth::user()->id)->get();
        return view('user.user_kasir_index', $data);
    }

    public function show($id)
    {
        $model = Model::where('user_id', Auth::user()->id)->get();
        return response()->json($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // INI TUTUP SAJA
    public function store(Request $request)
    {
        $produk = Produk::where('id', $request->produk_id)->first();

        // jika produk tidak ada
        if(!isset($produk)){
            toast('ERROR', 'error');
            return back();
        }

        // jika stok produk <= 0
        if($produk->jumlah <= 0){
            toast('Stok Habis', 'error');
            return back();
        }

        // keranjang pada produk tersebut sudah ada
        $authId = Auth::user()->id;
        $model = Model::where('user_id', $authId)->where('produk_id', $request->produk_id)->first();

        if(isset($model)){
            $model->update([
                'jumlah' => $model->jumlah +1,
            ]);

            toast('Data berhasil ditambah', 'success');
            return back();
        }

        // jika keranjang pada produk tersebut belum ada
        $request->validate([
            'produk_id' => 'required|numeric',
        ]);

        $model = Model::create([
            'user_id' => $authId,
            'produk_id' => $request->produk_id,
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

    public function add(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);

        $authId = Auth::user()->id;
        $keranjang = Model::where('user_id', $authId)
        ->where('produk_id', $request->produk_id)->first();

        $produk = Produk::where('id', $request->produk_id)->first();

        if($produk == null){
            toast('Produk tidak ditemukan', 'error');
            return back();
        }

        if($produk->jumlah < 1){
            toast('Stok habis', 'error');
            return back();
        }

        if($keranjang){
            $keranjang->update(['jumlah' => $keranjang->jumlah +1]);
            toast('Data berhasil ditambah', 'success');
            return back();
        };

        Model::create([
            'user_id' => $authId,
            'produk_id' => $request->produk_id,
            'jumlah' => 1
        ]);

        toast('Data berhasil ditambah', 'success');
        return back();
    }

    public function search($value)
    {
        $data = Produk::select("nama as value", "kode_barang", "id")
        ->where('nama', 'LIKE', '%'. $value. '%')
        ->orWhere('kode_barang', 'LIKE', '%'. $value. '%')
        ->get();

        return response()->json($data);
    }
}
