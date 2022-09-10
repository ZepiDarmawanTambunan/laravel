<?php
namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Produk as Model;
use App\Keranjang;
class PelangganProdukController extends Controller
{
    public function index(){
        $data['model'] = Model::where('jumlah', '>', '0')->latest()->paginate(8);
        return view('pelanggan.pelanggan_produk_index', $data);
    }
    public function detail($id)
    {
        $data['model'] = Model::findOrFail($id);
        return view('pelanggan.pelanggan_produk_detail', $data);
    }
    public function belisekarang($id)
    {
        $produk = Model::where('id', $id)->first();
        $authId = Auth::user()->id;
        if($produk == null){
            toast('Error invalid', 'error');
            return back();
        }
        if($produk->jumlah <= 0){
            toast('Stok Habis', 'error');
            return back();
        }
        $keranjang = Keranjang::where('user_id', $authId)->where('produk_id', $id)->first();
        if(isset($keranjang)){
            $keranjang->update([
                'jumlah' => $keranjang->jumlah +1,
            ]);
            toast('Data berhasil ditambah', 'success');
            return redirect('/pelanggan/keranjang');
        }
        $data['model'] = Keranjang::create([
            'user_id' => $authId,
            'produk_id' => $produk->id,
            'jumlah' => '1',
        ]);
        toast('Data berhasil ditambah', 'success');
        return redirect('/pelanggan/keranjang');
    }
}
