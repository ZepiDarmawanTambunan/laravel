<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Produk;
use App\Penjualan;
use App\Pembayaran;

class UserPencarianController extends Controller
{
    public function cari($tipe_pencarian)
    {
        $query = request('query');
        $auth = Auth::user();

        if($tipe_pencarian == 'penjualan' || $tipe_pencarian == 'pesanan'){

            if($auth->akses == 'pelanggan'){
                $data['model'] = Penjualan::where('kode', 'like', "%$query%")
                ->where('pelanggan_id', $auth->pelanggan->id)
                ->latest()
                ->paginate(5);
                return view('pelanggan.pelanggan_pesanan_index', $data);
            }
            $data['model'] = Penjualan::where('kode', 'like', "%$query%")->latest()->paginate(5);
            return view('user.user_penjualan_index', $data);
        }
        else if($tipe_pencarian == 'pembayaran'){
            $data['model'] = Penjualan::has('pembayaran')->where('kode', 'like', "%$query%")->get();

            $arr = [];
            foreach ($data['model'] as $key => $item) {
                array_push($arr, ...$item->pembayaran);
            }
            $data['model'] = $arr;

            return view('user.user_pembayaran_index', $data);
        }
        else if($tipe_pencarian == 'pengiriman'){
            $data['model'] = Penjualan::where('kode', 'like', "%$query%")->get();

            $arr = [];
            foreach ($data['model'] as $key => $item) {
                $hasPengiriman = $item->pengiriman ?? NULL;
                $hasBiayaPengiriman = $hasPengiriman != null ? ($hasPengiriman->biaya_pengiriman != null) : null;
                
                if(( $hasBiayaPengiriman && ($item->pelanggan->status == 'tetap' || $item->status_penjualan == 'lunas'))){
                    array_push($arr, $item);
                }
            }
            $data['model'] = $arr;
            
            return view('user.user_pengiriman_index', $data);
        }
        else{
            $data['model'] = Produk::where('nama', 'like', "%$query%")
            ->orWhere('kode_barang', 'like', "%$query%")->latest()->paginate(5);

            if($auth->akses == 'pelanggan'){
                return view('pelanggan.pelanggan_produk_index', $data);
            }

            return view('user.user_produk_index', $data);
        }
    }
}
