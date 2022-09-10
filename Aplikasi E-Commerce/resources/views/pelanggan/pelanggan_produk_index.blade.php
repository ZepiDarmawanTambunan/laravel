@extends('layouts.layout')

@section('title', 'Produk')
@section('subtitle', 'Pages')
@section('content')
    <div class="container mx-4 my-2">
        <h4 class="card-title mb-4">Produk</h4>

        <a href="{{ url('pelanggan/keranjang') }}" class="btn btn-primary mb-2 mx-2">
            <i class="fa fa-cart-plus"></i>
        </a>

        <div class="row center">
            @forelse ($model as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 px-2">
                    <a href="{{ url('pelanggan/produk/' . $item->id) }}" class="col-xl-3 col-lg-4 col-md-6 my-2">
                        <div class="card" style="height: 300px;">
                            <div class="card-body">
                                <img class="mb-3 img-fluid"
                                    src="{{ $item->image == null ? asset('quixlab-main') . '/theme/images/default/terpal_(2).jpg' : \Storage::url($item->image) }}"
                                    alt=""
                                    style="height: 150px;width:100%; background-size: cover; background-position: center;">
                                <h5 class="card-title text-cente">{{ $item->nama }}</h5>
                                <p class="card-text">Harga: Rp. {{ number_format($item->harga) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div>
                    <h4 class="text-center">Data tidak ada!</h4>
                </div>
            @endforelse
        </div>

        @if (isset($model))
            <div class="d-flex justify-content-center mt-2">
                {{ $model->links() }}
            </div>
        @endif
    </div>

@endsection
