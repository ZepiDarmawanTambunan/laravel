<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pembayaran as Model;

class UserPembayaranController extends Controller
{

    public function index()
    {
        $data['model'] = Model::orderBy('tgl_pembayaran', 'DESC')->get();
        return view('user.user_pembayaran_index', $data);
    }

    public function kategori($kategori)
    {
        $data['model'] = Model::where('status_pembayaran', $kategori)->get();
        return view('user.user_pembayaran_index', $data);
    }

    public function form($id)
    {
        $data['model'] = Model::where('id', $id)->first();
        return view('user.user_pembayaran_konfirmasi', $data);
    }

    public function konfirmasiPembayaran(Request $request)
    {
        $request->validate([
            'status_konfirmasi' => 'required',
            'id' => 'numeric|required|exists:pembayarans,id',
        ]);

        $auth = Auth::user();

        $pembayaran = Model::where('id', $request->id)->first();

        if($request->status_konfirmasi == 'terima'){
            $request->validate([
                'keterangan' => 'nullable',
            ]);

            $penjualan = $pembayaran->penjualan;
            $uang_penjualan = $pembayaran->uang_pembayaran+($penjualan->uang_penjualan ?? 0);

            $pembayaran->update([
                'user_id' => $auth->id,
                'status_pembayaran' => 'diterima'
            ]);

            if($uang_penjualan >= $penjualan->total){
                $penjualan->update([
                    'uang_penjualan' => $uang_penjualan,
                    'status_penjualan' => 'lunas'
                ]);
            }else{
                toast('Uang tidak cukup', 'error');
                return back();
            }

            toast('Berhasil', 'success');
            return redirect($auth->akses.'/penjualan/'.$penjualan->id);
        }
        else if($request->status_konfirmasi == 'tolak'){
            $request->validate([
                'keterangan' => 'required',
            ]);

            $pembayaran->update([
                'user_id' => $auth->id,
                'status_pembayaran' => 'ditolak',
                'keterangan' => $request->keterangan
            ]);

            toast('Berhasil', 'success');
            return redirect($auth->akses.'/penjualan/'.$pembayaran->penjualan->id);
        }

    }
}
