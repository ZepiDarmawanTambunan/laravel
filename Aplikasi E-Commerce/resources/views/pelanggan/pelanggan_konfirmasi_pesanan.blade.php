@extends('layouts.layout')

@section('title', 'Konfirmasi Pesanan')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">

            <h4 class="card-title mb-4">Konfirmasi Pesanan</h4>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Harga Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
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
            <br>

            @if ($model->count() > 0)
                {!! Form::open(['url' => 'pelanggan/pesanan', 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat_pengiriman">Alamat Lengkap</span></label>
                            <textarea class="form-control" type="text" name="alamat_pengiriman" rows="3" required readonly>{{ $alamat_pengiriman }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="catatan_pengiriman">Catatan Pengiriman (Optional)</label>
                            <textarea class="form-control" type="text" name="catatan_pengiriman" rows="3" readonly>{{ $catatan_pengiriman ?? '-' }}</textarea>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province">Provinsi Pengiriman</label>
                            <input type="text" class="form-control" value="{{ $province->title }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="city">Kota Pengiriman</label>
                            <input type="text" class="form-control" value="{{ $city->title }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="courier">Kurir</label>
                            <input type="text" class="form-control" value="{{ $courier }}" readonly name="courier">
                        </div>

                        <div class="form-group">
                            <label for="metode_pembayaran">Metode Pembayaran</label>
                            <input type="text" class="form-control" value="{{ $metode_pembayaran }}" readonly
                                name="metode_pembayaran">
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="beratTotal">Berat Barang (gram)</label>
                            <input type="text" class="form-control" value="{{ $beratTotal }}" readonly
                                name="beratTotal">
                        </div>
                        <div class="form-group">
                            <label for="estimasi_waktu">Estimasi Waktu</label>
                            <input type="text" class="form-control" value="{{ $estimasi_waktu }}" readonly
                                name="estimasi_waktu">
                        </div>
                        <p>Sub Total: Rp. {{ number_format($subTotal) }}</p>
                        @php
                            $total = $subTotal - ($subTotal / 100) * $diskon + $ongkir;
                        @endphp
                        <p>Diskon: {{ $diskon }} % || Rp. {{ number_format(($subTotal / 100) * $diskon) }}</p>
                        <p>Ongkir: {{ $gratis_ongkir == 'yes' ? 'gratis ongkir' : 'Rp. ' . number_format($ongkir) }}</p>
                        <p>Total: Rp. {{ number_format($total) }}</p>
                    </div>
                    <div class="col-md-12">

                        <button type="submit" class="btn btn-primary mt-2" id="clicked">
                            Submit
                        </button>

                        <p class="mt-4">
                            KETERANGAN
                            <br /> * Pesanan dapat dibatalkan selama belum melakukan upload bukti pembayaran
                        </p>


                        <input type="hidden" readonly name="total" value="{{ $total }}">
                        <input type="hidden" readonly name="diskon" value="{{ $diskon }}">
                        <input type="hidden" readonly name="ongkir" value="{{ $ongkir }}">
                        <input type="hidden" readonly name="city_id" value="{{ $city->city_id }}">
                        <input type="hidden" readonly name="province_id" value="{{ $province->province_id }}">
                        <input type="hidden" readonly name="kode_diskon" value="{{ $kode_diskon }}">
                        <input type="hidden" readonly name="beratTotal" value="{{ $beratTotal }}">
                        <input type="hidden" readonly name="model[]" value="{{ json_encode($model) }}">
                    </div>
                </div>
                {!! Form::close() !!}
            @endif


        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        // kodeDiskonInput.addEventListener('input', kodeDiskonCheck);

        // let defaultUrl = check.getAttribute('href').split("-");

        // function kodeDiskonCheck(e) {
        //     let kode = e.target.value == '' ? '-' : e.target.value;
        //     let url = defaultUrl[0] + kode;

        //     check.setAttribute('href', url);
        // }
    </script>
@endsection
