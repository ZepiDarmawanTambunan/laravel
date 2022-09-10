<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Produk as Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class UserProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::latest()->paginate(5);
        return view('user.user_produk_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['id'] = IdGenerator::generate(['table' => 'produks', 'field' => 'kode_barang', 'length' => '6', 'prefix' => 'B-']);
        $data['model'] = new Model();
        $data['method'] = 'POST';
        $data['url'] = url(Auth::user()->akses .'/produk');
        $data['namaTombol'] = 'Simpan';
        return view('user.user_produk_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $harga = (int)str_replace('.', '', str_replace('Rp. ', '', $request->harga)) ?? '0';

        // general validate
        $request->validate([
            'nama' => 'required|string|max:255|unique:produks',
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',
            'harga' => 'required|max:10000000|min:2',
            'kode_barang' => 'required',
            'jumlah' => 'required|numeric|max:10000|min:1',
            'berat' => 'required|numeric|max:100000|min:1',
            'deskripsi' => 'required',
        ]);

        // handle image nullable
        $image = "";
        if(isset($request->image)){
            $image = $request->file('image')->store('public/produk');
        }

        // create user
        $model = Model::create([
            'kode_barang' => $request->kode_barang,
            'nama' => $request->nama,
            'image' => $image,
            'harga' =>$harga,
            'jumlah' => $request->jumlah,
            'berat' => $request->berat,
            'deskripsi' => $request->deskripsi,
            'user_id' => Auth::user()->id,
        ]);

        toast('Data berhasil ditambah', 'success');
        return redirect(Auth::user()->akses.'/produk');
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
        return view('user.user_produk_detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['model'] = Model::findOrFail($id);
        $data['method'] = 'PUT';
        $data['url'] = url(Auth::user()->akses .'/produk/' . $id);
        $data['namaTombol'] = 'Ubah';

        return view('user.user_produk_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $harga = (int)str_replace('.', '', str_replace('Rp. ', '', $request->harga)) ?? '0';

        $request->merge([
            'harga' => $harga,
        ]);

        // general validate
        $request->validate([
            'nama' => 'required', 'string', 'max:255',
            'harga' => 'required|numeric|max:10000000|min:2',
            'jumlah' => 'required|numeric|max:10000|min:1',
            'berat' => 'required|numeric|max:100000|min:1',
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',
            'deskripsi' => 'required',
        ]);

        if($request->harga <= 0){
            toast('format pengisian salah', 'error');
            return back()->withErrors([
                'harga' => 'lebih besar dari 0'
            ]);
        }

        $model = Model::findOrFail($id);
         // jika input gambar tidak disi kita pakai gambar default di database
         $image = $model->image;
         // jika input gambar ada isinya
         if($request->image != null){
             // kita atur direcotry file gambarnya
             $image = $request->file('image')->store('public/produk');
             // jika gambar didatabase tidak kosong, maka kita hapus dulu
             if($model->image != null){
                 Storage::delete($model->image);
             }
         }

         $model->update([
             'nama' => $request->nama,
             'harga' => $request->harga,
             'jumlah' => $request->jumlah,
             'deskripsi' => $request->deskripsi,
             'berat' => $request->berat,
             'image' => $image,
         ]);

        toast('Data berhasil diubah', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        
        if($model->keranjang->count() > 0){
            $model->keranjang->each->delete();    
        }        

        if($model->penjualanDetail->count() > 0){
            foreach ($model->penjualanDetail as $key => $value) {
                if($value->penjualan->penjualanDetails->count() == 1){
                    if($value->penjualan->pengiriman != null){
                        $value->penjualan->pengiriman->delete();
                    }

                    if($value->penjualan->pembayaran->count() > 0){
                        $value->penjualan->pembayaran->each->delete();
                    }
                    
                    $value->penjualan->delete();
                }
            } 
            $model->penjualanDetail->each->delete();
        }
        
        Storage::delete($model->image);
        $model->delete();

        toast('berhasil dihapus', 'success');
        return back();
    }
}
