<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Province;
use App\Pelanggan;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/pelanggan/beranda';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showRegistrationForm()
    {
        $data['provinces'] = Province::pluck('title', 'province_id');
        return view('auth.register', $data);
    }

    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'regex:/(.+)@(.+)\.(.+)/i', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['required', 'numeric'],
            'jk' => ['required', 'in:laki-laki,perempuan'],
            'alamat' => ['required', 'max:350'],
            'city_id' => ['required', 'numeric', 'exists:cities,city_id'],
            'province_id' =>  ['required', 'numeric', 'exists:provinces,province_id'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $result = User::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'akses' => 'pelanggan',
            'alamat' => $data['alamat'],
            'no_hp' => str_replace("0","62", $data['no_hp']),
        ]);

        Pelanggan::create([
            'user_id' => $result->id,
            'jk' => $data['jk'],
            'city_id' => $data['city_id'],
            'province_id' => $data['province_id']
        ]);

        return $result;
    }

}
