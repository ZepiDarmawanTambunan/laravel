<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Rekening as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PemilikRekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::latest()->paginate(5);
        return view('pemilik.pemilik_rekening_index', $data);
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
        $data['url'] = url('pemilik/rekening');
        $data['namaTombol'] = 'Simpan';
        return view('pemilik.pemilik_rekening_form', $data);
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
            'nama_bank' => 'required', 'unique:rekenings,nama_bank',
            'nomor_rekening' => 'required', 'numeric',
            'nama_pemilik' => 'required',
        ]);

        Model::create([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        toast('Data berhasil dibuat', 'success');
        return redirect('pemilik/rekening');
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
        $data['url'] = url('pemilik/rekening/' . $id);
        $data['namaTombol'] = 'Ubah';
        return view('pemilik.pemilik_rekening_form', $data);
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
            'nama_bank' => 'required', 'unique:rekenings,nama_bank',
            'nomor_rekening' => 'required', 'numeric',
            'nama_pemilik' => 'required',
        ]);

        $model = Model::findOrFail($id);

        $model->update([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        toast('Data berhasil diubah', 'success');
        return redirect('pemilik/rekening');
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
