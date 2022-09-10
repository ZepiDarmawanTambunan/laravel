<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['model'] = User::findOrFail($id);
        $data['method'] = 'PUT';
        $data['url'] = url('admin/profile/' . $id);
        $data['namaTombol'] = 'Ubah';

        return view('admin.admin_profile', $data);
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
            'new_password' => 'min:3|nullable',
            'no_hp' => 'required|numeric|min:10',
            'jk' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required',
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
        if($request->password && $request->new_password != null){
            if(!Hash::check($request->password, $model->password)){
                toast('Gagal! Password lama tidak sama', 'error');
                return back();
            };
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

        $model->admin->update([
            'jk' => $request->jk,
        ]);

        toast('Data berhasil diubah', 'success');
        return back();
    }
}
