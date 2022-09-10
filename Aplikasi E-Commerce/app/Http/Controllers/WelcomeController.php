<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class WelcomeController extends Controller
{
    public function index()
    {
        $data['pemilik'] = User::where('akses', 'pemilik')->first();
        $data['admin1'] = User::where('akses', 'admin')->get()[0] ?? null;
        $data['admin2'] = User::where('akses', 'admin')->get()[1] ?? null;

        return view('welcome', $data);
    }
}
