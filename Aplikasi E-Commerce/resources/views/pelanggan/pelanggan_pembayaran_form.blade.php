@extends('layouts.layout')

@section('title', 'Pembayaran')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Pembayaran</h4>
            @php
                $subTotal = 0;
            @endphp

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model->penjualanDetails as $item)
                            @php
                                $subTotal += $item->produk->harga * $item->jumlah;
                            @endphp
                            <tr>
                                <td>{{ $item->produk->kode ?? 'Belum Tersedia' }}</td>
                                <td>{{ $item->produk->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp. {{ number_format($item->produk->harga) }}</td>
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
                    <p>Status Pembayaran: {{ $model->status_penjualan }}</p>
                    <br>
                    <p>Silahkan Bayar Ke Nomor Rekening Berikut:</p>
                    @forelse ($rekening as $item)
                        <p>{{ $item->nama_bank }} - {{ $item->nomor_rekening }}</p>
                    @empty
                        <p>-- No Rekening Belum Tersedia --</p>
                    @endforelse
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
            <form action="/pelanggan/pembayaran" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group mt-3">
                    <label for="uang_pembayaran">Nominal Uang <span class="text-danger">*</span></label>
                    <input type="text" id="uang_pembayaran" class="form-control" name="uang_pembayaran" required>
                    <span class="text-danger" style="font-size:12px;">{{ $errors->first('uang_pembayaran') }}</span>
                </div>

                <div class="form-group">
                    <label for="rekening_id">Pilih Rekening Tujuan <span class="text-danger">*</span></label>
                    <select class="form-control" name="rekening_id" required>
                        @foreach ($rekening as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_bank }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" style="font-size:12px;">{{ $errors->first('image') }}</span>
                </div>

                <div class="form-group">
                    <label for="image">Bukti Pembayaran <span class="text-danger">*</span></label>
                    {!! Form::file('image', ['class' => 'btn border col-sm-4 col-md-12', 'required']) !!}
                    <span class="text-danger" style="font-size:12px;">{{ $errors->first('image') }}</span>
                </div>

                <input type="hidden" value="{{ $model->id }}" name="id">
                <button type="submit" class="btn btn-primary btn-block mt-4">Submit</button>
            </form>


            <p class="mt-4">
                Keterangan
                <br>* Harap tunggu pesanan yang sedang diproses. Jika lebih dari 1 x 24 jam. silahkan kunjungi menu hubungi kami
                <br /> * Pesanan dapat dibatalkan selama belum melakukan upload bukti pembayaran
            </p>
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
