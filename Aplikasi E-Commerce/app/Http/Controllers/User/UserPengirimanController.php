<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pengiriman as Model;
use App\Penjualan;

class UserPengirimanController extends Controller
{
    public function index()
    {
        $data['model'] = Penjualan::where('status_penjualan', 'lunas')->get();
        $arr = array();

        foreach ($data['model'] as $key => $item) {
            if(($item->pengiriman ?? null) != null){
                array_push($arr, $item);
            }
        }

        $data['model'] = collect($arr);
        $arr = null;

        return view('user.user_pengiriman_index', $data);
    }

    public function kategori($kategori)
    {
        $data['model'] = Penjualan::where('status_penjualan', 'lunas')->get();

        $arr = array();

        foreach ($data['model'] as $key => $item) {
            if(($item->pengiriman ?? null) != null)
            {
                if($item->pengiriman->status_pengiriman == $kategori){
                    array_push($arr, $item);
                }
            }
        }

        $data['model'] = collect($arr);
        $arr = null;

        return view('user.user_pengiriman_index', $data);
    }

    public function form($id)
    {
        $data['model'] = Model::where('id', $id)->first();
        return view('user.user_pengiriman_form', $data);
    }

    public function ubahPengiriman(Request $request)
    {
        $request->validate([
            'id' => 'numeric|required|exists:pengirimans,id',
            'no_resi' => 'nullable|min:3',
            'status_pengiriman' => 'required|in:sedang dikemas,dikirim,diterima',
            'keterangan' => 'nullable'
        ]);

        $pengiriman = Model::where('id', $request->id)->first();

        $pengiriman->update([
            'id' => $request->id,
            'no_resi' => $request->no_resi,
            'status_pengiriman' => $request->status_pengiriman,
            'keterangan' => $request->keterangan ?? '',
        ]);

        toast('Berhasil', 'success');
        return back();
    }
}
