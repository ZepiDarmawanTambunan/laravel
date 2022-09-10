<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Beranda as Model;

class UserBerandaController extends Controller
{
    public function berandaPemilik()
    {
        $data['model'] = Model::where('status', 'pemilik')->first();
        return view('layouts.beranda', $data);
    }

    public function berandaAdmin()
    {
        $data['model'] = Model::where('status', 'admin')->first();
        return view('layouts.beranda', $data);
    }

    public function berandaPelanggan()
    {
        $data['model'] = Model::where('status', 'pelanggan')->first();
        return view('layouts.beranda', $data);
    }

    public function formBeranda($status)
    {
        $data['model'] = Model::where('status', $status)->first();
        $data['status'] = $status;

        if($status == 'pemilik'){
            $data['status'] = 'pemilik';
            return view('user.user_beranda_form', $data);
        }
        else if($status == 'admin'){
            $data['status'] = 'admin';
            return view('user.user_beranda_form', $data);
        }
        else{
            $data['status'] = 'pelanggan';
            return view('user.user_beranda_form', $data);
        }
    }


    public function storeBeranda(Request $request)
    {
        $authId = Auth::user()->id;
        $model = Model::where('status', $request->status)->first();

        $request->validate([
            'judul' => 'required|min:15',
            'sub_judul' => 'required|min:15',
            'deskripsi' => 'required|min:15',
            'status' => 'required',
            'image' => 'file|nullable|mimes:png,jpg,jpeg,svg,webp|max:10000',
            'video' => 'required'
        ]);

        if($model){
            $image = $model->image;
            if($request->image != null){
                $image = $request->file('image')->store('public/beranda');
                if($model->image != null){
                    Storage::delete($model->image);
                }
            }

            $model->update([
                'judul' => $request->judul,
                'sub_judul' => $request->sub_judul,
                'deskripsi' => $request->deskripsi,
                'video' => $request->video,
                'image' => $image,
                'user_id' => $authId
            ]);

            toast('Data berhasil diubah', 'success');
            return redirect(Auth::user()->akses.'/beranda');
        }

        $request->validate([
            'image' => 'file|required|mimes:png,jpg,jpeg,svg,webp|max:10000',
        ]);

        $image = "";
        if(isset($request->image)){
            $image = $request->file('image')->store('public/beranda');
        }

        $model = Model::create([
            'judul' => $request->judul,
            'sub_judul' => $request->sub_judul,
            'deskripsi' => $request->deskripsi,
            'video' => $request->video,
            'status' => $request->status,
            'image' => $image,
            'user_id' => $authId
        ]);

        toast('Data berhasil ditambah', 'success');
        return redirect(Auth::user()->akses.'/beranda');
    }
}
