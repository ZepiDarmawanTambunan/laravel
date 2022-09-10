<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Penjualan as Model;
use App\PenjualanDetail;
use App\Diskon;
use App\Pengiriman;
use App\User;
use App\Rekening;
use App\Keranjang;
use App\City;
use App\Produk;
use App\Province;
use Carbon\Carbon;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class PelangganPesananController extends Controller
{
    public function index()
    {
        $authPelangganId = Auth::user()->pelanggan->id;
        $data['model'] = Model::where('pelanggan_id', $authPelangganId)->latest()->paginate(5);
        return view('pelanggan.pelanggan_pesanan_index', $data);
    }
    public function konfirmasiPesanan(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|min:10',
            'kode_diskon' => 'nullable',
            'catatan_pengiriman' => 'nullable',
            'subTotal' => 'required',
            'metode_pembayaran' => 'required',
            'beratTotal' => 'required',
            'courier' => 'required|in:jne,tiki,pos',
            'city_id' => 'required|numeric|exists:cities,city_id',
            'province_id' => 'required|numeric|exists:provinces,province_id',
        ]);

        if($request->model[0] == null || $request->model[0] == '' || $request->model[0] == '[]'){
            toast('Gagal', 'error');
            return redirect('pelanggan/produk');
        }

        $data['diskon'] = 0;
        $data['gratis_ongkir'] = 'no';
        if($request->kode_diskon != null){
            $diskon = Diskon::where('kode', $request->kode_diskon)->first();
            if($diskon == null){
                toast('Kode diskon salah', 'error');
                return back();
            }
            $waktu_skrg = date('Y-m-d');
            $diskon_tgl_berakhir = date_format($diskon->tgl_berakhir, 'Y-m-d');
            if($diskon_tgl_berakhir<$waktu_skrg){
                toast('Kode diskon kadaluwarsa', 'error');
                return back();
            }else if($diskon->jumlah <= 0){
                toast('Kode diskon habis', 'error');
                return back();
            }
            $data['gratis_ongkir'] = $diskon->gratis_ongkir;
            $data['diskon'] = $diskon->poin;
        }

        $pemilik = User::where('akses', 'pemilik')->first();
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $pemilik->pemilik->city_id, // ID kota/kabupaten asal
            'destination'   => $request->city_id, // ID kota/kabupaten tujuan
            'weight'        => $request->beratTotal, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        $data['alamat_pengiriman'] = $request->alamat_pengiriman;
        $data['subTotal'] = $request->subTotal;
        $data['beratTotal'] = $request->beratTotal;
        $data['catatan_pengiriman'] = $request->catatan_pengiriman;
        $data['model'] = Keranjang::where('user_id', Auth::user()->id)->get();
        $data['kode_diskon'] = $request->kode_diskon;
        $data['province'] = Province::where('province_id', $request->province_id)->first();
        $data['city'] = City::where('city_id', $request->city_id)->first();
        $data['courier'] = $request->courier;

        $data['ongkir'] = $cost[0]['costs'][0]['cost'][0]['value'];
        if($data['gratis_ongkir'] == 'yes'){
            $data['ongkir'] = 0;
        }
        if($data['province']->province_id == $pemilik->pemilik->province_id){
            $data['ongkir'] = 0;
            $data['gratis_ongkir'] = 'yes';
        }

        $data['metode_pembayaran'] = $request->metode_pembayaran ?? 'transfer-bank';
        $data['estimasi_waktu'] = $cost[0]['costs'][0]['cost'][0]['etd'];
        return view('pelanggan.pelanggan_konfirmasi_pesanan', $data);
    }
    public function store(Request $request)
    {
        $kode = $this->generateKode(\Str::random(5) .'/'. Carbon::now()->format('d/m/y'));

        $auth = Auth::user();
        if($request->kode_diskon != null){
            $diskon = Diskon::where('kode', $request->kode_diskon)->first();
            $diskon->update([
                'jumlah' => $diskon->jumlah -1,
            ]);
        }

        $penjualan = Model::create([
            'pelanggan_id' => $auth->pelanggan->id,
            'kode' => $kode,
            'status_penjualan' => 'belum bayar',
            'disc_point' => $request->diskon,
            'total' => $request->total,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        $pengiriman = Pengiriman::create([
            'penjualan_id' => $penjualan->id,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'status_pengiriman' => 'sedang dikemas',
            'catatan_pengiriman' => $request->catatan_pengiriman ?? '',
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
            'biaya_pengiriman' => $request->ongkir,
            'estimasi_waktu' => $request->estimasi_waktu,
            'jasa_pengirim' => $request->courier,
            'berat' => $request->beratTotal
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

        if($penjualan->metode_pembayaran == 'cod'){
            $penjualan->update(['status_penjualan' => 'lunas']);
        }

        $model = Keranjang::where('user_id', $auth->id)->get();
        $model->each->delete();
        toast('Berhasil', 'success');
        return redirect('/pelanggan/produk');
    }
    public function detail($id)
    {
        $data['model'] = Model::findOrFail($id);
        $data['rekening'] = Rekening::latest()->get();
        $data['province'] = Province::where('province_id', $data['model']->pengiriman->province_id)->first();
        $data['city'] = City::where('city_id', $data['model']->pengiriman->city_id)->first();
        return view('pelanggan.pelanggan_pesanan_detail', $data);
    }
    public function batal($id)
    {
        $data = Model::where('id',$id)->first();

        if(($data->pelanggan_id ?? null) !=  Auth::user()->pelanggan->id){
            toast('Gagal', 'error');
            return redirect('/pelanggan/pesanan');
        }

        $check = $data->pembayaran->where('status_pembayaran', '!=', 'ditolak');
        $statusPembayaran = $check->count() == 0 ? 'ok' : 'not ok';

        if(($data->pengiriman->status_pengiriman ?? null) == 'sedang dikemas'
        && $statusPembayaran == 'ok'
        && ($data->status_penjualan ?? null) == 'belum bayar'){
            foreach ($data->penjualanDetails as $key => $item) {
                $produk = Produk::where('id', $item->produk_id)->first();
                if($produk){
                    $produk->update(['jumlah' => $produk->jumlah+$item->jumlah]);
                }
            }

            $data->penjualanDetails->each->delete();

            if(($data->pengiriman ?? null) != null){
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
        return redirect('/pelanggan/pesanan');
    }
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
