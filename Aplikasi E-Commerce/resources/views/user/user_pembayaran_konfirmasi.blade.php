@extends('layouts.layout')

@section('title', 'Pembayaran')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Konfirmasi Pembayaran
            </h4>

            <div class="card-body">
                @php
                    $subTotal = 0;
                @endphp
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($model->penjualan->penjualanDetails as $item)
                                @php
                                    $subTotal += $item->produk->harga * $item->jumlah;
                                @endphp
                                <tr>
                                    <td>{{ $item->produk->kode_barang ?? 'Belum Tersedia' }}</td>
                                    <td>{{ $item->produk->nama }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp. {{ number_format($item->produk->harga) }}</td>
                                    <td>Rp. {{ number_format($item->produk->harga * $item->jumlah) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ada!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col">
                        <p>Status Pembayaran: {{ $model->penjualan->status_penjualan }}</p>
                    </div>
                    <div class="col-md-3 offset-md-3">
                        <p>Sub Total: Rp. {{ number_format($subTotal) }}</p>
                        <p>Biaya Ongkir: Rp. {{ number_format($model->penjualan->pengiriman->biaya_pengiriman ?? 0) }}</p>
                        <p>Diskon: {{ $model->disc_point }} % || Rp.
                            {{ number_format(($subTotal / 100) * $model->disc_point) }}</p>
                        <hr>
                        <p>Total: Rp. {{ number_format($model->penjualan->total ?? 0) }}</p>
                    </div>
                </div>
                <div class="basic-form">
                    <form action="{{ url(Auth::user()->akses . '/pembayaran/') }}" method="post" enctype="multipa-data">
                        {{ csrf_field() }}
                        <div class="form-group mt-3">
                            <label for="uang_pembayaran">Nominal Uang</label>
                            <input type="text" id="uang_pembayaran"
                                value="Rp. {{ number_format($model->uang_pembayaran) }}" class="form-control" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="nama_bank">Rekening Tujuan</label>
                            <input type="text" id="nama_bank" value="{{ $model->rekening->nama_bank }}"
                                class="form-control" readonly>
                        </div>

                        <a href="{{\Storage::url($model->image)}}" target="_blank">
                            <img src="{{ \Storage::url($model->image) }}" style="height: 300px; width: 300px;"
                                class="img-fluid" alt="image pembayaran">
                        </a>
                        <hr>

                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan (wajib di-isi jika pesanan ditolak)</label>
                            <textarea id="keterangan" type="text" class="form-control" rows="3" name="keterangan">{{$model->keterangan}}</textarea>
                            <span class="text-danger" style="font-size:12px;">{{ $errors->first('keterangan') }}</span>
                        </div>

                        <input type="hidden" value="{{ $model->id }}" name="id" required>

                        @if($model->status_pembayaran == 'sedang diproses')
                            <div class="d-flex justify-content-around">
                                {!! Form::submit('terima', [
                                    'class' => 'btn btn-primary mr-2',
                                    'name' => 'status_konfirmasi',
                                    'value' => 'terima',
                                ]) !!}
                                
                                {!! Form::submit('tolak', ['class' => 'btn btn-danger', 'name' => 'status_konfirmasi', 'value' => 'tolak']) !!}  
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    @endsection
