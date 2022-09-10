@extends('layouts.layout')

@section('title', 'Pembayaran')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Pembayaran
            </h4>

            @php
                $subTotal = 0;
                $sisaPembayaran = 0;
                if (($model->penjualan->uang_penjualan ?? 0) < ($model->penjualan->total ?? 0)) {
                    $sisaPembayaran = $model->penjualan->total - $model->penjualan->uang_penjualan;
                }
            @endphp
            <div class="row">
                <div class="col">
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
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p>Status Pembayaran: {{ $model->penjualan->status_penjualan }}</p>
                </div>
                <div class="col-md-3 offset-md-3">
                    <p>Sub Total: Rp. {{ number_format($subTotal) }}</p>
                    <p>Biaya Ongkir: Rp. {{ number_format($model->penjualan->pengiriman->biaya_pengiriman ?? 0) }}</p>
                    <p>Diskon: {{ $model->penjualan->disc_point }} % || Rp.
                        {{ number_format(($subTotal / 100) * $model->penjualan->disc_point) }}</p>
                    <hr>
                    <p>Total: Rp. {{ number_format($model->penjualan->total ?? 0) }}</p>
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="uang_pembayaran">Nominal Uang</label>
                <input type="text" id="uang_pembayaran" value="Rp. {{ number_format($model->uang_pembayaran) }}"
                    class="form-control" readonly>
            </div>

            <div class="form-group mt-3">
                <label for="nama_bank">Rekening Tujuan</label>
                <input type="text" id="nama_bank" value="{{ $model->rekening->nama_bank }}" class="form-control"
                    readonly>
            </div>

            <a href="{{\Storage::url($model->image)}}" target="_blank">
                <img src="{{ \Storage::url($model->image) }}" style="height: 300px; width: 300px;"
                    class="img-fluid" alt="image pembayaran">
            </a>
            <hr>

            <div class="form-group mt-3">
                <label for="keterangan">Keterangan (admin)</label>
                <textarea id="keterangan" type="text" class="form-control" rows="3" readonly></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div
                        class="text-center text-white p-2 {{ $model->status_pembayaran == 'diterima' ? 'bg-success' : 'bg-danger' }} ">
                        {{ $model->status_pembayaran }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        const uang_pembayaran = document.getElementById('uang_pembayaran');

        uang_pembayaran.addEventListener('input', handleUangPembayaran);

        function handleUangPembayaran(e) {
            uang_pembayaran.value = formatRupiah(e.target.value, "Rp. ");
        }
    </script>
@endsection
