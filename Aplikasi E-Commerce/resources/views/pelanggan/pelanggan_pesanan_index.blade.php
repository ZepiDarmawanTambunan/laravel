@extends('layouts.layout')

@section('title', 'Pesanan')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Pesanan</h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>TGL</th>
                            <th>Kode</th>
                            <th>Status Pembayaran</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->pembayaran->where('status_pembayaran', 'sedang diproses')->first() ? 'sedang diproses' : $item->status_penjualan }}
                                </td>
                                <td>Rp. {{ number_format($item->total ?? 0) }}</td>
                                <td>
                                    {{-- $item->total == null ? pelanggan/konfirmasi : pelanggan/pesanan --}}
                                    <a href="{{ url('pelanggan/pesanan/' . $item->id) }}" class="btn btn-warning">
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

            <!-- <p>
                Keterangan<br>
                * Harap tunggu pesanan yang sedang diproses. Hubungi kami melalui Link ini jika lebih dari 24 jam pesanan
                belum dikonfirmasi
            </p> -->

            @if (isset($model))
                <div class="d-flex justify-content-center mt-2">
                    {{ $model->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
