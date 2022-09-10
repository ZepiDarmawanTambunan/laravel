@extends('layouts.layout')

@section('title', 'Produk')
@section('subtitle', 'Pages')
@section('content')
    <div class="card shadow mx-2 mb-4 mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 col-12">
                    <img src={{ $model->image == null ? asset('quixlab-main') . '/theme/images/default/terpal_(2).jpg' : \Storage::url($model->image) }}
                        alt="Card image cap" style="width: 100%; height:330px;">
                </div>
                <div class="col-md-6">
                    <h2>{{ $model->nama }}</h2>
                    <p class="mt-2 mt-md-4">Harga: Rp. {{ number_format($model->harga) }}</p>
                    <p>Stok: {{ $model->jumlah }}</p>
                    <p>Berat: {{ $model->berat }} Gram</p>
                    <a href="{{ url('pelanggan/produk/belisekarang/' . $model->id) }}" class="btn btn-success mt-1">
                        Beli Sekarang
                    </a>
                    <a href="{{ url('pelanggan/keranjang/' . $model->id) }}" class="btn btn-primary mt-1">
                        <i class="fa fa-cart-plus"></i> Masukan Keranjang
                    </a>
                </div>
                <div class="col-lg-1 mt-2 mt-lg-0">
                    <a href="{{ url('pelanggan/keranjang') }}" class="btn btn-primary mb-2 mx-2">
                        <i class="fa fa-cart-plus"></i>
                    </a>
                </div>
            </div>
            <div class="row mt-3 mt-md-2">
                <div class="col">
                    <h2>Deskripsi</h2>
                    <p class="text-justify">{{ $model->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
