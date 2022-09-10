<?php

namespace App\Http\Controllers\Pemilik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Province;

class PemilikProfileController extends Controller
{
    public function edit($id)
    {
        $data['model'] = User::findOrFail($id);
        $data['method'] = 'PUT';
        $data['url'] = url('pemilik/profile/' . $id);
        $data['namaTombol'] = 'Ubah';
        $data['provinces'] = Province::pluck('title', 'province_id');
        $data['province_id'] = $data['model']->pemilik->province_id;
        $data['city_id'] = $data['model']->pemilik->city_id;

        return view('pemilik.pemilik_profile', $data);
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
        $model = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|min:3|max:255',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,'.$model->id,
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',
            'password' => 'min:3|nullable',
            'deskripsi' => 'required',
            'peta_gmap' => 'required',

            'no_hp' => 'required|min:10',
            'alamat' => 'required',
            'city_id' => 'required|numeric|exists:cities,city_id',
            'province_id' => 'required|numeric|exists:provinces,province_id',
        ]);

        // FORMAT CEK NO HP UTK INDO
        $no_hp = $request->no_hp;
        $no_hp_08 = substr($no_hp, 0,2);
        $no_hp_628 = substr($no_hp, 0,3);

        if($no_hp_08 != '08' && $no_hp_628 != '628'){
            toast('Gagal! format No HP salah', 'error');
            return back()->withErrors([
                'no_hp' => 'format 628 atau 08'
            ]);
        }

        if($no_hp_08 == '08'){
            $no_hp = str_replace("08","628", $no_hp);
        }
        // END FORMAT NOHP

        $password = $model->password;
        if($request->password != null){
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

        $model->pemilik->update([
            'deskripsi' => $request->deskripsi,
            'peta_gmap' => $request->peta_gmap,
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
        ]);

        toast('Data berhasil diubah', 'success');
        return back();
    }
}
