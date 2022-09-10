@extends('layouts.layout')

@section('title', 'Kebijakan')
@section('subtitle', 'Pages')
@section('content')
    @forelse ($model as $item)
        <div class="card mx-4 my-4">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    {{ $item->judul }}
                </h4>
                <p class="mt-3 text-primary">
                    {{ $item->sub_judul }}
                </p>
                <p class="text-justify">{{ $item->deskripsi }}</p>
            </div>
        </div>
    @empty
        <div class="text-center">Data Tidak Ada</div>
    @endforelse
@endsection
