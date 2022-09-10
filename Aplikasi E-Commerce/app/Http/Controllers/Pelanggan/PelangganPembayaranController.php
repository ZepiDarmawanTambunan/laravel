<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Penjualan;
use App\Rekening;
use App\Pembayaran as Model;

class PelangganPembayaranController extends Controller
{
    public function create($id)
    {
        $data['model'] = Penjualan::where('id', $id)->first();
        $data['rekening'] = Rekening::latest()->get();
        return view('pelanggan.pelanggan_pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        $uang_pembayaran = (int)str_replace('.', '', str_replace('Rp. ', '', $request->uang_pembayaran)) ?? '0';

        $request->merge([
            'uang_pembayaran' => $uang_pembayaran,
        ]);

        $request->validate([
            'uang_pembayaran' => 'required|numeric|max:100000000|min:2',
            'image' => 'file|required|mimes:png,jpg,jpeg,svg,webp|max:10000',
            'id' => 'required|numeric|exists:penjualans,id',
            'rekening_id' => 'required|numeric|exists:rekenings,id'
        ]);

        $penjualan = Penjualan::where('id', $request->id)->first();

        if($penjualan->pembayaran->where('status_pembayaran', 'sedang diproses')->count() >= 1){
            toast('Gagal', 'Hanya bisa sekali melakukan pembayaran, mohon tunggu !');
            return redirect('/pelanggan/pesanan');
        }

        if($uang_pembayaran < $penjualan->total){
            toast('Gagal', 'error');
            return back()->withErrors([
                'uang_pembayaran' => 'Uang Tidak Cukup!'
            ]);
        }

        $image = $request->file('image')->store('public/pembayaran');

        Model::create([
            'penjualan_id' => $request->id,
            'rekening_id' => $request->rekening_id,
            'uang_pembayaran' => $request->uang_pembayaran,
            'image' => $image,
            'status_pembayaran' => 'sedang diproses'
        ]);

        toast('Berhasil', 'success');
        return redirect('pelanggan/pesanan/'.$request->id);
    }

    public function detail($id)
    {
        $data['model'] = Model::where('id', $id)->first();
        return view('pelanggan.pelanggan_pembayaran_detail', $data);
    }
}
