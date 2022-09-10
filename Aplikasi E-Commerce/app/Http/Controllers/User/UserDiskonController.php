<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Diskon as Model;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserDiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['model'] = Model::latest()->paginate(5);
        return view('user.user_diskon_index', $data);
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
        $data['url'] = url(Auth::user()->akses .'/diskon');
        $data['namaTombol'] = 'Simpan';
        return view('user.user_diskon_form', $data);
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
            'kode' => 'required', 'unique:diskons,kode',
            'poin' => 'required', 'numeric', 'max:100', 'min:1',
            'jumlah' => 'required', 'numeric', 'max:10000',
            'tgl_berakhir' => 'required',
            'gratis_ongkir' => 'required|in:yes,no',
        ]);

        if($request->poin <= 0){
            toast('format pengisian salah', 'error');
            return back()->withErrors([
                'poin' => 'lebih besar dari 0'
            ]);
        }else if($request->jumlah <= 0){
            toast('format pengisian salah', 'error');
            return back()->withErrors([
                'jumlah' => 'lebih besar dari 0'
            ]);
        }

        $tgl_berakhir = strtotime($request->tgl_berakhir);

        Model::create([
            'user_id' => Auth::user()->id,
            'kode' => $request->kode,
            'poin' => $request->poin,
            'jumlah' => $request->jumlah,
            'tgl_berakhir' => $tgl_berakhir,
            'gratis_ongkir' => $request->gratis_ongkir,
        ]);

        toast('Data berhasil dibuat', 'success');
        return redirect(Auth::user()->akses.'/diskon');
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
        $data['url'] = url(Auth::user()->akses.'/diskon/' . $id);
        $data['namaTombol'] = 'Ubah';
        return view('user.user_diskon_form', $data);
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
            'kode' => 'required', 'unique:diskons,kode',
            'poin' => 'required', 'numeric',
            'jumlah' => 'required', 'numeric',
            'tgl_berakhir' => 'required',
            'gratis_ongkir' => 'required|in:yes,no',
        ]);

        if($request->poin <= 0){
            toast('format pengisian salah', 'error');
            return back()->withErrors([
                'poin' => 'lebih besar dari 0'
            ]);
        }else if($request->jumlah <= 0){
            toast('format pengisian salah', 'error');
            return back()->withErrors([
                'jumlah' => 'lebih besar dari 0'
            ]);
        }

        $tgl_berakhir = strtotime($request->tgl_berakhir);

        $model = Model::findOrFail($id);

        $model->update([
            'kode' => $request->kode,
            'poin' => $request->poin,
            'jumlah' => $request->jumlah,
            'tgl_berakhir' => $tgl_berakhir,
            'gratis_ongkir' => $request->gratis_ongkir,
        ]);

        toast('Data berhasil diubah', 'success');
        return redirect(Auth::user()->akses.'/diskon');
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
