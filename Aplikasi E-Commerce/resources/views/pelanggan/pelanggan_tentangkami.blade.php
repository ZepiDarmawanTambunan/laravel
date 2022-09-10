@extends('layouts.layout')

@section('title', 'Tentang Kami')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Tentang Kami
            </h4>

            <img class="border text-center"
                style="background-repeat: no-repeat; background-position:center; background-size: contain;" height="330"
                width="100%"
                src="{{ ($model->image ?? null) == null ? asset('quixlab-main') . '/theme/images/store_9.jpg' : \Storage::url($model->image) }}"
                alt="Card image cap">

            <p class="text-justify mt-2">
                {{ $model->pemilik->deskripsi ?? 'tidak ada deskripsi' }}
            </p>


            <div class="row mt-4" style="position: relative; overflow:hidden;">
                <div class="col">
                    {{ $model->name ?? 'PT. Aneka Terpal' }}<br />
                    {{ $model->alamat ?? 'Kota Jambi' }} <br />
                    No HP: {{ '+'.$model->no_hp ?? '+628983299382' }} <br />
                    Email: {{$model->email ?? 'pt.anekaterpal@gmail.com'}} <br />
                </div>
                <div class="col">
                    {!! $model->pemilik->peta_gmap !!}
                </div>
            </div>
        </div>
    </div>
@endsection
