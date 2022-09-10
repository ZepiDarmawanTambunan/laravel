<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Kebijakan as Model;
use Illuminate\Support\Facades\Auth;

class UserKebijakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::get();
        return view('pemilik.pemilik_kebijakan_index', $data);
    }

    public function indexPelanggan()
    {
        $data['model'] = Model::get();
        return view('user.user_kebijakan_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['model'] = new Model();
        $data['method'] = 'POST';
        $data['url'] = url('pemilik/kebijakan');
        $data['namaTombol'] = 'Simpan';
        return view('pemilik.pemilik_kebijakan_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required', 'min:3',
            'sub_judul' => 'required',
            'deskripsi' => 'required',
        ]);

        Model::create([
            'judul' => $request->judul,
            'sub_judul' => $request->sub_judul,
            'deskripsi' => $request->deskripsi
        ]);

        toast('Data berhasil dibuat', 'success');
        return redirect(Auth::user()->akses.'/kebijakan');
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
        $data['url'] = url('pemilik/kebijakan/' . $id);
        $data['namaTombol'] = 'Ubah';
        return view('pemilik.pemilik_kebijakan_form', $data);
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
        $request->validate([
            'judul' => 'required', 'min:3',
            'sub_judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $model = Model::findOrFail($id);

        $model->update([
            'judul' => $request->judul,
            'sub_judul' => $request->sub_judul,
            'deskripsi' => $request->deskripsi
        ]);

        toast('Data berhasil dibuat', 'success');
        return redirect(Auth::user()->akses.'/kebijakan');
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
        $model->delete();
        toast('Data berhasil dihapus', 'success');
        return back();
    }
}
