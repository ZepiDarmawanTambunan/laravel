<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        # code...
    }

    public function beranda(){
        $data['akses'] = 'Admin';
        return view('layouts.beranda', $data);
    }
}
