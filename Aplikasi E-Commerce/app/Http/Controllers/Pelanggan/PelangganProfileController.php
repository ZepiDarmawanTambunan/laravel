<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Province;
class PelangganProfileController extends Controller
{
    public function edit($id)
    {
        $data['model'] = User::findOrFail($id);
        $data['method'] = 'PUT';
        $data['url'] = url('pelanggan/profile/' . $id);
        $data['namaTombol'] = 'Ubah';
        $data['transaksi'] = [];
        $data['provinces'] = Province::pluck('title', 'province_id');
        $data['province_id'] = $data['model']->pelanggan->province_id;
        $data['city_id'] = $data['model']->pelanggan->city_id;

        return view('pelanggan.pelanggan_profile', $data);
    }

    public function update(Request $request, $id)
    {
        $model = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|min:3|max:255',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users,email,'.$model->id,
            'image' => 'file|mimes:png,jpg,jpeg,svg,webp|max:10000|nullable',
            'password' => 'min:3|nullable',
            'new_password' => 'min:3|nullable',
            'no_hp' => 'required|numeric',
            'jk' => 'required|in:laki-laki,perempuan',
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


        // jika input new pw dan old pw tidak disi maka pakai pw yg lama saja, krn dak diubah
        $password = $model->password;
        // jika input new pw dan oldpw ada isinya
        if($request->password && $request->new_password != null){
            // jika input old pw != pw yg didatabase maka error
            if(!Hash::check($request->password, $model->password)){
                toast('Gagal! Password lama tidak sama', 'error');
                return back()->withErrors([
                    'password' => 'password lama tidak sama'
                ]);
            };
            // jika input old pw == pw yg didatabase maka kita hash new pw
            $password = Hash::make($request->new_password);
        }

        $image = $model->image;
        if($request->image != null){
            $image = $request->file('image')->store('public/profil');
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
            'alamat' => $request->alamat
        ]);

        $model->pelanggan->update([
            'jk' => $request->jk,
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
        ]);

        toast('Data berhasil diubah', 'success');
        return back();
    }
}
