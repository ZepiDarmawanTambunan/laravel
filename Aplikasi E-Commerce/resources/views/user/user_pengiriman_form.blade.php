@extends('layouts.layout')

@section('title', 'Pengiriman')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Pengiriman
            </h4>

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
                    <p>Biaya Ongkir: Rp. {{ number_format($model->biaya_pengiriman ?? 0) }}</p>
                    <p>Diskon: {{ $model->disc_point }} % || Rp.
                        {{ number_format(($subTotal / 100) * $model->disc_point) }}</p>
                    <hr>
                    <p>Total: Rp. {{ number_format($model->penjualan->total ?? 0) }}</p>
                </div>
            </div>
            <div class="basic-form">
                <form action="{{ url(Auth::user()->akses . '/pengiriman/') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="">Biaya Ongkos Kirim</label>
                        <input type="text" class="form-control" id="biaya_pengiriman"
                            value="Rp. {{ number_format($model->biaya_pengiriman ?? '0') }}" readonly>
                    </div>

                    <div class="form-group mt-3">
                        <label for="catatan_pengiriman">catatan_pengiriman</label>
                        <textarea id="catatan_pengiriman" type="text" class="form-control" rows="3" readonly>{{ $model->catatan_pengiriman }}</textarea>
                    </div>


                    <div class="form-group">
                        <label for="jasa_pengirim">Jasa Pengirim</label>
                        <input type="text" class="form-control" value="{{ $model->jasa_pengirim ?? '' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="estimasi_waktu">Estimasi Waktu</label>
                        <input type="text" class="form-control" id="estimasi_waktu" value="{{ $model->estimasi_waktu }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="no_resi">No Resi (optional)</label>
                        <input type="text" class="form-control" id="no_resi" value="{{ $model->no_resi ?? '' }}"
                            name="no_resi">
                    </div>

                    <div class="form-group">
                        <label for="status_pengiriman">Status Pengiriman <span class="text-danger">*</span></label>
                        <select class="form-control" name="status_pengiriman" required>
                            <option value="sedang dikemas"
                                {{ $model->status_pengiriman == 'sedang dikemas' ? 'selected' : '' }}>
                                Sedang Dikemas</option>
                            <option value="dikirim" {{ $model->status_pengiriman == 'dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="diterima" {{ $model->status_pengiriman == 'diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="keterangan">Keterangan (optional)</label>
                        <textarea id="keterangan" type="text" class="form-control" rows="3" name="keterangan">{{ $model->keterangan }}</textarea>
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('keterangan') }}</span>
                    </div>


                    <input type="hidden" value="{{ $model->id }}" name="id" required>

                    <button type="submit" class="btn btn-block col-md-6 offset-md-3 btn-primary">Submit</button>
                </form>
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
