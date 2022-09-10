@extends('layouts.layout')

@section('title', 'Penjualan')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar Penjualan
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
                    <a class="dropdown-item" href="{{ url($authAkses . '/penjualan') }}">Semua</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/penjualan/kategori/lunas') }}">Lunas</a>
                    <a class="dropdown-item" href="{{ url($authAkses . '/penjualan/kategori/belum bayar') }}">Belum
                        Bayar</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>TGL</th>
                            <th>Kode</th>
                            <th>Status Penjualan</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->status_penjualan??'-' }}</td>
                                <td>{{ 'Rp. ' . number_format($item->total) }}
                                </td>
                                <td>
                                    {{-- $item->total == null ? pelanggan/konfirmasi : pelanggan/pesanan --}}
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ url($authAkses . '/penjualan/' . $item->id) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-info"></i>
                                            </a>
                                        </div>
                                        @php
                                            $check = $item->pembayaran->where('status_pembayaran', '!=', 'ditolak');
                                            $statusPembayaran = $check->count() == 0 ? 'ok' : 'not ok';
                                        @endphp
                                        <div class="col">
                                            @if (($item->pengiriman->status_pengiriman ?? null) == 'sedang dikemas' &&
                                                $statusPembayaran == 'ok' &&
                                                ($item->status_penjualan ?? null) == 'belum bayar')
                                                
                                                {!! Form::open(['url' => $authAkses . '/penjualan/batal/' . $item->id, 'method' => 'GET']) !!}
                                                    <button type="submit" class="btn btn-danger show_confirm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                {!! Form::close() !!}
                                            @endif
                                        </div>
                                    </div>
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

            @if (isset($model))
                <div class="d-flex justify-content-center mt-2">
                    {{ $model->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
