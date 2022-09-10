@extends('layouts.layout')

@section('title', 'Pembayaran')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar Pembayaran
            </h4>
            <div class="dropdown show mb-3">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Kategori
                </a>
                @php
                    $authAkses = Auth::user()->akses;
                @endphp
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ url($authAkses . '/pembayaran') }}">Semua</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pembayaran/kategori/diterima') }}">Diterima</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pembayaran/kategori/sedang diproses') }}">Sedang
                        Diproses</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/pembayaran/kategori/ditolak') }}">Ditolak</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>TGL</th>
                            <th>Kode</th>
                            <th>Status Pembayaran</th>
                            <th>Uang Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ date('Y-m-d H:i', strtotime($item->tgl_pembayaran??date('Y-m-d')))}}</td>
                                <td>{{ $item->penjualan->kode }}</td>
                                <td>{{ $item->status_pembayaran }}</td>
                                <td>{{ 'Rp ' . number_format($item->uang_pembayaran) }}</td>
                                <td>
                                    {{-- $item->total == null ? pelanggan/konfirmasi : pelanggan/pesanan --}}
                                    <a href="{{ url($authAkses . '/pembayaran/' . $item->id) }}" class="btn btn-warning">
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
