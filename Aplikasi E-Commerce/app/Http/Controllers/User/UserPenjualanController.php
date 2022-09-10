<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Penjualan as Model;
use App\Keranjang;
use App\Rekening;
use App\PenjualanDetail;
use Carbon\Carbon;
use App\Produk;
use App\Province;
use App\City;

class UserPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::latest()->paginate(5);
        return view('user.user_penjualan_index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // konversi ke int dan hilangkan tulisan rupiah dan handle value="sadasd" ? 0
        $uang_penjualan = (int)str_replace('.', '', str_replace('Rp. ', '', $request->uang_penjualan)) ?? '0';
        $total = (int)$request->total;

        // $request->biaya_pengiriman = $biaya_pengiriman
        // gunakan merge jika ingin mengubah value $request, kalau pakai yg diatas gk bisa
        $request->merge([
            'uang_penjualan' => $uang_penjualan,
            'total' => $total,
        ]);

        $auth = Auth::user();

        $request->validate([
            'nama_pelanggan' => 'required|max:1000',
            'uang_penjualan' => 'required|numeric|max:10000000',
            'total' => 'required|numeric',
            'disc_point' => 'nullable|numeric',
        ]);

        //jika uang_penjualan < total = uang dak cukup
        if($uang_penjualan<$total){
            toast('Gagal', 'error');
            return back()->withErrors([
                'uang_penjualan' => 'Uang Tidak Cukup!'
            ]);
        }
        // jika data keranjang kosong maka balik ke kasi
        else if($request->model[0] == null){
            toast('Gagal', 'error');
            return redirect($auth->akses.'/kasir');
        }

        // rekursif check kode penjualan
        $kode = $this->generateKode(\Str::random(5) .'/'. Carbon::now()->format('d/m/y'));

        $penjualan = Model::create([
            'user_id' => $auth->id,
            'kode' => $kode,
            'nama_pelanggan' => $request->nama_pelanggan,
            'status_penjualan' => 'lunas',
            'disc_point' => $request->disc_point ?? 0,
            'total' => $request->total,
            'uang_penjualan' => $request->uang_penjualan,
            'metode_pembayaran' => 'cash',
        ]);

        $model = json_decode($request->model[0], true);

        foreach ($model as $key => $item) {
            $value = new Keranjang($item);

            $penjualanDetail = PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $value->produk_id,
                'jumlah' => $value->jumlah
            ]);

            $penjualanDetail->produk->update([
                'jumlah' => $penjualanDetail->produk->jumlah - $penjualanDetail->jumlah,
            ]);
        }

        $model = Keranjang::where('user_id', $auth->id)->get();
        $model->each->delete();

        toast('Berhasil', 'success');
        return redirect($auth->akses.'/laporan/pdf/'.$penjualan->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['model'] = Model::findOrFail($id);
        if(($data['model']->pengiriman ?? null) != null){
            $data['rekening'] = Rekening::latest()->get();
            $data['province'] = Province::where('province_id', $data['model']->pengiriman->province_id)->first();
            $data['city'] = City::where('city_id', $data['model']->pengiriman->city_id)->first();
        }
        return view('user.user_penjualan_detail', $data);
    }

    public function kategori($kategori)
    {
        $data['model'] = Model::where('status_penjualan', $kategori)->latest()->paginate(5);
        return view('user.user_penjualan_index', $data);
    }

    public function konfirmasiPesanan(Request $request, $id)
    {
        $request->validate([
            'status_konfirmasi' => 'required',
        ]);

        $authAkses = Auth::user()->akses;

        if($request->status_konfirmasi == 'terima'){

            $biaya_pengiriman = (int)str_replace('.', '', str_replace('Rp. ', '', $request->biaya_pengiriman)) ?? '0';

            // $request->biaya_pengiriman = $biaya_pengiriman
            // gunakan merge jika ingin mengubah value $request, kalau pakai yg diatas gk bisa
            $request->merge([
                'biaya_pengiriman' => $biaya_pengiriman,
            ]);

            $request->validate([
                'no_resi' => 'nullable|max:1000',
                'jasa_pengirim' => 'required',
                'estimasi_waktu' => 'required|numeric',
                'keterangan' => 'nullable',
                'biaya_pengiriman' => 'required|numeric'
            ]);

            $data['model'] = Model::findOrFail($id);

            $total = 0;
            //subtotal
            foreach ($data['model']->penjualanDetails as $key => $item) {
                $total += $item->produk->harga * $item->jumlah;
            }
            // disc point
            $total -= $data['model']->disc_point ? ($total * $data['model']->disc_point) / 100 : 0;
            // biayapengiriman
            $total += $request->biaya_pengiriman;

            $data['model']->update([
                'total' => $total
            ]);

            $data['model']->pengiriman->update([
                'no_resi' => $request->no_resi ?? '',
                'jasa_pengirim' => $request->jasa_pengirim ?? '',
                'estimasi_waktu' => $request->estimasi_waktu ?? '',
                'keterangan' => $request->keterangan ?? '',
                'biaya_pengiriman' => $request->biaya_pengiriman,
            ]);

            toast('Berhasil', 'success');
            return redirect($authAkses.'/penjualan/');

        }else if($request->status_konfirmasi == 'tolak'){

            $request->validate([
                'keterangan' => 'required',
            ]);

            $data['model'] = Model::findOrFail($id);

            $data['model']->update([
                'status_penjualan' => 'ditolak'
            ]);

            $data['model']->pengiriman->update([
                'keterangan' => $request->keterangan
            ]);

            toast('Berhasil', 'success');
            return redirect($authAkses.'/penjualan/');
        }
    }

    public function batal($id)
    {

    //     @if (($item->pengiriman->status_pengiriman ?? null) != 'dikirim' &&
    //     ($item->pengiriman->status_pengiriman ?? null) != 'diterima' &&
    //     $item->status_penjualan == 'belum bayar')
    //     <a href="{{ url(Auth::user()->akses . '/penjualan/batal/' . $item->id) }}"
    //         class="btn btn-danger show_confirm"><i class="fas fa-trash-alt"></i></a>
    // @endif

        $data = Model::findOrFail($id);
        $check = $data->pembayaran->where('status_pembayaran', '!=', 'ditolak');
        $statusPembayaran = $check->count() == 0 ? 'ok' : 'not ok';

        if(($data->pengiriman->status_pengiriman ?? null) == 'sedang dikemas'
        && $statusPembayaran == 'ok'
        && ($data->status_penjualan ?? null) == 'belum bayar')
        {
            foreach ($data->penjualanDetails as $key => $item) {
                $produk = Produk::where('id', $item->produk_id)->first();
                if($produk){
                    $produk->update(['jumlah' => $produk->jumlah+$item->jumlah]);
                }
            }

            $data->penjualanDetails->each->delete();
            if($data->pengiriman != null){
                $data->pengiriman->delete();
            }
            if($data->pembayaran->count() != 0){
                $data->pembayaran->each->delete();
            }

            $data->delete();
            toast('Berhasil', 'success');
        }else{
            toast('Gagal', 'error');
        }
        return redirect(Auth::user()->akses.'/penjualan');
    }

    // pelunasan secara online (user bisa saja upload bukti klo dia udah chatan dgn admin) dimasukan aja nominal sesuai agar lunas. nanti admin akan terima
    // pelunasan secara offline

    public function generateKode($kode)
    {
        $check = Model::where('kode', $kode)->first();

        if(!$check){
            return $kode;
        }

        $kode = \Str::random(5).'/'.Carbon::now()->format('d/m/y');
        return $this->generateKode($kode);
    }
}
