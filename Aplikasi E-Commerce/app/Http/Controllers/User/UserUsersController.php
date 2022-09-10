<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User as Model;
use App\Pelanggan;
use App\Penjualan;
use App\Province;
use App\Admin;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['authAkses'] = Auth::user()->akses;
        $condition = $data['authAkses'] == 'pemilik' ? '!=' : '=';
        $user = $data['authAkses'] == 'pemilik' ? 'pemilik' : 'pelanggan';

        $data['model'] = Model::where('akses', $condition, $user)->latest()->paginate(5);
        return view('user.user_users_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['model'] = new Model();
        $data['method'] = 'POST';
        $data['authAkses'] = Auth::user()->akses;
        $data['url'] = url($data['authAkses'].'/user');
        $data['namaTombol'] = 'Simpan';
        $data['akses'] = $request->akses;

        if($data['akses'] == 'pelanggan'){
            $data['provinces'] = Province::pluck('title', 'province_id');
        }
        return view('user.user_users_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // general validate
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',
            'jk' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|numeric|min:10',
            'alamat' => 'required',
        ]);

        // FORMAT CEK NO HP UTK INDO
        $no_hp = $request->no_hp;
        $no_hp_08 = substr($no_hp, 0,2);
        $no_hp_628 = substr($no_hp, 0,3);

        if($no_hp_08 != '08' && $no_hp_628 != '628'){
            toast('format no hp salah', 'error');
            return back()->withErrors([
                'no_hp' => 'format 628 atau 08'
            ]);
        }

        if($no_hp_08 == '08'){
            $no_hp = str_replace("08","628", $no_hp);
        }
        // END FORMAT NOHP

        // check validate input admin or pasien
        if($request->akses == 'pelanggan'){
            $request->validate([
                'city_id' => 'required|numeric|exists:cities,city_id',
                'province_id' => 'required|numeric|exists:provinces,province_id',
            ]);
        }

        // handle image nullable
        $image = "";
        if(isset($request->image)){
            $image = $request->file('image')->store('public/profil');
        }

        // create user
        $model = Model::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'akses' => $request->akses,
            'image' => $image,
            'no_hp' => $no_hp,
            'alamat' => $request->alamat,
        ]);

        // create admin or pasien
        if($request->akses == 'admin'){
            Admin::create([
                'user_id' => $model->id,
                'jk' => $request->jk,
            ]);
        }else if($request->akses == 'pelanggan'){
            Pelanggan::create([
                'user_id' => $model->id,
                'jk' => $request->jk,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
            ]);
        }else{
            toast('request akses not valid', 'error');
            return back();
        }

        toast('Data berhasil ditambah', 'success');
        return redirect(Auth::user()->akses.'/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $data['authAkses'] = Auth::user()->akses;
        $data['url'] = url($data['authAkses'].'/user/' . $id);
        $data['namaTombol'] = 'Ubah';
        $data['akses'] = $data['model']->akses;

        $data['transaksi'] = [];
        if($data['model']->akses == 'pelanggan'){
            $data['transaksi'] = $data['model']->pelanggan->penjualan;
            $data['provinces'] = Province::pluck('title', 'province_id');
            $data['province_id'] = $data['model']->pelanggan->province_id;
            $data['city_id'] = $data['model']->pelanggan->city_id;
        }

        return view('user.user_users_form', $data);
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
        $model = Model::findOrFail($id);

        // general validate
        $request->validate([
            'nama' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255', 'unique:users',
            'password' => 'nullable', 'string', 'min:8',
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',

            'no_hp' => 'required|numeric|min:10',
            'jk' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required',
        ]);

        // FORMAT CEK NO HP UTK INDO
        $no_hp = $request->no_hp;
        $no_hp_08 = substr($no_hp, 0,2);
        $no_hp_628 = substr($no_hp, 0,3);

        if($no_hp_08 != '08' && $no_hp_628 != '628'){
            toast('format no hp salah', 'error');
            return back()->withErrors([
                'no_hp' => 'format 628 atau 08'
            ]);
        }

        if($no_hp_08 == '08'){
            $no_hp = str_replace("08","628", $no_hp);
        }
        // END FORMAT NOHP


        if($request->akses == 'pelanggan'){
            $request->validate([
                'city_id' => 'required|numeric|exists:cities,city_id',
                'province_id' => 'required|numeric|exists:provinces,province_id',
            ]);
        }

        // jika input pw null maka pakai pw dari db
        $password = $model->password;
        // jika input pw ada isinya
        if($request->password != null){
            // maka pw nya kita ganti jadi yg terbaru
            $password = Hash::make($request->password);
        }

        // jika input gambar tidak disi kita pakai gambar default di database
        $image = $model->image;
        // jika input gambar ada isinya
        if($request->image != null){
            // kita atur direcotry file gambarnya
            $image = $request->file('image')->store('public/profil');
            // jika gambar didatabase tidak kosong, maka kita hapus dulu
            if($model->image != null){
                Storage::delete($model->image);
            }
        }

        $model->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $password,
            'image' => $image,

            'no_hp' => $no_hp,
            'alamat' => $request->alamat,
        ]);

        if($request->akses == 'pelanggan'){
            $model->pelanggan->update([
                'jk' => $request->jk,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
            ]);
        }else if($request->akses == 'admin'){
            $model->admin->update([
                'jk' => $request->jk,
            ]);
        }else{
            toast('request akses not valid', 'error');
            return back();
        }

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
        Storage::delete($model->image);

        if($model->akses == 'admin'){
            if($model->diskon->count() > 0){
                $model->diskon->each->delete();
            }

            if($model->keranjang->count() > 0){
                $model->keranjang->each->delete();
            }

            if($model->produk->count() > 0){
                foreach ($model->produk as $key => $value) {
                    $value->update(['user_id' => '1']);
                }
            }

            if($model->penjualan->count() > 0){
                foreach ($model->penjualan as $key => $value) {
                    $value->update(['user_id' => '1']);
                }
            }

            if($model->pembayaran->count() > 0){
                foreach ($model->pembayaran as $key => $value) {
                    $value->update(['user_id' => '1']);
                }
            }

            $admin = Admin::where('user_id', $model->id)->first();
            $admin->delete();
        }
        else if($model->akses == 'pelanggan'){

            if($model->keranjang->count() > 0){
                $model->keranjang->each->delete();
            }

            if($model->pelanggan->penjualan->count() > 0){
                foreach ($model->pelanggan->penjualan as $key => $value) {
                    if($value->penjualanDetails->count() > 0){
                        $value->penjualanDetails->each->delete();
                    }

                    if($value->pembayaran->count() > 0){
                        $value->pembayaran->each->delete();
                    }

                    $value->pengiriman->delete();
                    $value->delete();
                }
            }

            $model->pelanggan->delete();
        }else{
            return back();
        }

        $model->delete();

        toast('Data berhasil dihapus', 'success');
        return back();
    }
}
