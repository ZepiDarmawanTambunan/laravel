@extends('layouts.layout')

@section('title', 'Pengiriman')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar Pengiriman
            </h4>
            @php
                $authAkses = Auth::user()->akses;
            @endphp
            <div class="dropdown show mb-3">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Kategori
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ url($authAkses . '/pengiriman') }}">Semua</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pengiriman/kategori/diterima') }}">Diterima</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pengiriman/kategori/dikirim') }}">Dikirim</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pengiriman/kategori/sedang dikemas') }}">Sedang
                        Dikemas</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>TGL</th>
                            <th>Kode</th>
                            <th>No Resi</th>
                            <th>Status Pengiriman</th>
                            <th>Estimasi Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->pengiriman->no_resi ??'-' }}</td>
                                <td>{{ $item->pengiriman->status_pengiriman ?? '-' }}</td>
                                <td>{{ $item->pengiriman->estimasi_waktu ?? '-' }}</td>
                                <td>
                                    <a href="{{ url($authAkses . '/pengiriman/' . ($item->pengiriman->id ?? '0')) }}"
                                        class="btn btn-warning">
                                        <i class="fa fa-info"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ada!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
