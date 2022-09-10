@extends('layouts.layout')

@section('title', 'Pesanan')
@section('subtitle', 'Pages')
@section('content')
    <h2 class="text-center">Detail Pesanan</h2>
    <div class="card mx-4 my-2">
        @php
            $subTotal = 0;
            $statusPengiriman = $model->pengiriman->status_pengiriman ?? null;
            $statusPembayaran = $model->pembayaran->count() == 0 ? 'ok' : 'not';
            $check = $model->pembayaran->where('status_pembayaran', '!=', 'ditolak');
            $statusPembayaran = $check->count() == 0 ? 'ok' : 'not ok';
        @endphp
        <div class="card-body">
            <h4 class="card-title mb-4">Pembayaran</h4>

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
                        @forelse ($model->penjualanDetails as $item)
                            @php
                                $subTotal += $item->produk->harga * $item->jumlah;
                            @endphp
                            <tr>
                                <td>{{ $item->produk->kode_barang ?? '-' }}</td>
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
                    <p>Status Pesanan:
                        {{ $model->pembayaran->where('status_pembayaran', 'sedang diproses')->first() ? 'sedang diproses' : $model->status_penjualan }}
                    </p>
                    <p>Metode Pembayaran: {{ $model->metode_pembayaran ?? 'transfer-bank' }}</p>
                    <br>
                    @if ($model->status_penjualan != 'lunas')
                        <p>Silahkan Bayar Ke Nomor Rekening Berikut:</p>
                        @forelse ($rekening as $item)
                            <p>{{ $item->nama_bank }} - {{ $item->nomor_rekening }}</p>
                        @empty
                            <p>-- No Rekening Belum Tersedia --</p>
                        @endforelse
                    @endif
                </div>
                <div class="col-md-3 offset-md-3">
                    <p>Sub Total: Rp. {{ number_format($subTotal) }}</p>
                    <p>Biaya Ongkir: Rp. {{ number_format($model->pengiriman->biaya_pengiriman ?? 0) }}</p>
                    <p>Diskon: {{ $model->disc_point }} % || Rp.
                        {{ number_format(($subTotal / 100) * $model->disc_point) }}</p>
                    <hr>
                    <p>Total: Rp. {{ number_format($model->total ?? 0) }}</p>
                </div>
            </div>

            @if ($model->status_penjualan != 'lunas' && $statusPembayaran == 'ok')
                <a href="{{ url('/pelanggan/pembayaran/' . $model->id) }}" class="btn btn-block btn-primary mt-2"><i
                        class="fa fa-credit-card"></i> Bayar</a>
            @endif
            @if ($statusPengiriman == 'sedang dikemas' &&
                $model->status_penjualan == 'belum bayar' &&
                $statusPembayaran == 'ok')
                <a href="{{ url('pelanggan/pesanan/batal/' . $model->id) }}" class="btn btn-danger btn-block mt-4"><i
                        class="fa fa-times"></i> Batalkan</a>
            @endif
        </div>
    </div>

    <div class="card mx-4 my-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                <i class="fa fa-truck"></i>
                Pengiriman
            </h4>

            <div class="row">
                <div class="col">
                    <span class="font-weight-bold">No. Resi:
                    </span><span>{{ $model->pengiriman->no_resi ?? '-' }}</span><br>
                    <span class="font-weight-bold">Status Pengiriman:
                    </span><span>{{ $model->pengiriman->status_pengiriman ?? 'Sedang Dikonfirmasi' }}</span><br>
                    <span class="font-weight-bold">Ekspedisi:
                    </span><span>{{ $model->pengiriman->jasa_pengirim ?? '-' }}</span><br>
                    <span class="font-weight-bold">Waktu Estimasi:
                    </span><span>{{ $model->pengiriman->estimasi_waktu ?? '-' }}</span><br>
                    <span class="font-weight-bold">Berat Barang:
                    </span><span>{{ $model->pengiriman->berat . ' gram' ?? '-' }}</span><br>
                    <span class="font-weight-bold">Biaya Pengiriman:
                    </span><span>{{ 'Rp. ' . number_format($model->pengiriman->biaya_pengiriman) ?? '-' }}</span><br>
                </div>
                <div class="col">
                    <span class="font-weight-bold">Alamat Pengiriman:
                    </span><br><span>{{ $model->pengiriman->alamat_pengiriman ?? '-' }}</span><br>
                    <span class="font-weight-bold">Provinsi:
                    </span><span>{{ $province->title ?? '-' }}</span><br>
                    <span class="font-weight-bold">Kota:
                    </span><span>{{ $city->title ?? '-' }}</span><br>
                    <span class="font-weight-bold">Catatan Pengiriman: </span><br>
                    <span>{{ $model->pengiriman->catatan_pengiriman ?? '-' }}</span><br>
                    <span class="font-weight-bold">Keterangan Admin: </span><br>
                    <span>{{ $model->pengiriman->keterangan ?? '-' }}</span>
                </div>
            </div>
            @if ($model->status_pengiriman == 'dikirim')
                <a href="{{ url('/pelanggan/pesanan/diterima/' . $model->id) }}" class="btn btn-primary">Diterima</a>
            @endif
        </div>
    </div>

    <div class="card card mx-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Detail Pembayaran
            </h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>TGL Bayar</th>
                            <th>Status Pembayaran</th>
                            <th>Admin</th>
                            <th>Uang Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model->pembayaran as $item)
                            <tr>
                                <td>{{ $item->tgl_pembayaran ?? '-' }}</td>
                                <td>{{ $item->status_pembayaran ?? '-' }}</td>
                                <td>{{ $item->user->nama ?? '-' }}</td>
                                <td>{{ 'Rp. ' . number_format($item->uang_pembayaran) ?? '-' }}</td>
                                <td>
                                    <a href="{{ url('pelanggan/pembayaran/detail/' . $item->id) }}"
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
