@extends('layouts.layout')

@section('title', 'Keranjang')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">

            <h4 class="card-title mb-4">Keranjang</h4>

            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
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
                        @php
                            $diskon = session('diskon');
                            $beratTotal = 0;
                            $subTotal = 0;
                        @endphp
                        @forelse ($model as $item)
                            @php
                                $beratTotal += $item->produk->berat * $item->jumlah;
                                $subTotal += $item->produk->harga * $item->jumlah;
                            @endphp
                            <tr>
                                <td>{{ $item->produk->kode_barang }}</td>
                                <td>{{ $item->produk->nama }}</td>
                                <td>
                                    <a href="" class="label gradient-2 btn-rounded {{ $item->id }}" id="minus">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                    <span class="mx-3">{{ $item->jumlah }}</span>
                                    <a href="" class="label gradient-1 btn-rounded {{ $item->id }}"
                                        id="plus">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </td>
                                <td>Rp. {{ number_format($item->produk->harga) }}</td>
                                <td id="{{ $item->produk->berat }}">Rp.
                                    {{ number_format($item->produk->harga * $item->jumlah) }}</td>
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
                {!! Form::open(['url' => 'pelanggan/pesanan/konfirmasi', 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="kode_diskon">Kode Diskon (opsional)</label>
                            <input class="form-control" placeholder="Masukan Kode Diskon" id="kode_diskon" type="text"
                                name="kode_diskon" maxlength="6" value="{{ $diskon->kode ?? '' }}" />
                            <span class="text-danger" style="font-size:12px;">{{ $errors->first('kode_diskon') }}</span>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="province_id">Provinsi <span class="text-danger">*</span></label>
                                <select name="province_id" class="form-control" required>
                                    <option value="">--Provinsi--</option>
                                    @foreach ($provinces as $province => $value)
                                        <option value="{{ $province }}"
                                            {{ $province == $province_id ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="city_id">Kota <span class="text-danger">*</span></label>
                                <select name="city_id" class="form-control" required>
                                    <option value="">--Kota--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="alamat_pengiriman">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea class="form-control" placeholder="Masukan Alamat Lengkap" id="alamat_pengiriman" type="text"
                                name="alamat_pengiriman" rows="3" required>{{ Auth::user()->alamat }}</textarea>
                            <span class="text-danger"
                                style="font-size:12px;">{{ $errors->first('alamat_pengiriman') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="">Kurir <span class="text-danger">*</span></label>
                            <select name="courier" class="form-control" required>
                                @foreach ($couriers as $courier => $value)
                                    <option value="{{ $courier }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="metode_pembayaran">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" name="metode_pembayaran" required>
                                <option value="transfer-bank">Transfer Bank</option>
                                <option value="cod">COD</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="catatan_pengiriman">Catatan Pengiriman (Optional)</label>
                            <textarea class="form-control" placeholder="Catatan Pengiriman" id="catatan_pengiriman" type="text"
                                name="catatan_pengiriman" rows="3"></textarea>
                            <span class="text-danger"
                                style="font-size:12px;">{{ $errors->first('catatan_pengiriman') }}</span>
                        </div>


                        <button type="submit" class="btn btn-primary mt-2" id="clicked">
                            Submit
                        </button>

                        <p class="mt-4">
                            KETERANGAN
                            <br /> * Pesanan dapat dibatalkan selama belum melakukan upload bukti pembayaran
                        </p>

                        <input type="hidden" readonly name="beratTotal" value="{{ $beratTotal }}" id="beratTotal">
                        <input type="hidden" readonly name="subTotal" value="{{ $subTotal }}" id="subTotal">
                        <input type="hidden" readonly name="model[]" value="{{ json_encode($model) }}" id="model">
                    </div>
                </div>
                {!! Form::close() !!}
            @endif


        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        const kodeDiskonInput = document.querySelector('#kode_diskon');
        const check = document.getElementById('check');
        const subTotal = document.getElementById('subTotal');
        const beratTotal = document.getElementById('beratTotal');
        const model = document.getElementById('model');

        // ONGKIR
        $(document).ready(function() {
            let cityId = {!! json_encode($city_id) !!}
            let provinceId = $('select[name="province_id"]').val();

            if (provinceId) {
                jQuery.ajax({
                    url: '/province/' + provinceId + '/cities',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('select[name="city_id"]').empty();
                        $.each(data, function(key, value) {
                            if (key == cityId) {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '" selected>' + value +
                                    '</option>');
                            } else {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            }
                        });
                    }
                });
            }

            $('select[name="province_id"]').on('change', function() {
                provinceId = $(this).val();
                if (provinceId) {
                    jQuery.ajax({
                        url: '/province/' + provinceId + '/cities',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);

                            $('select[name="city_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_origin"]').empty();
                }
            });
        });


        // HANDLE BUTTON PLUS AND MINUS
        const tableRes = document.querySelector('.table-responsive');
        const pathPlus = "keranjang/plus/";
        const pathMinus = "keranjang/minus/";
        const pathModel = "keranjang/get/model";

        tableRes.addEventListener('click', async function(e) {
            e.preventDefault();
            let el = e.target;
            let elTbody = tableRes.children[0].children[1];
            // HANDLE BUTTON PLUS
            if (el.id == 'plus' || el.className.includes('fa-plus')) {
                let cartId = el.id == 'plus' ?
                    el.className.split(' ')[3] : el.parentElement.className.split(' ')[3];

                const result = await fetch(pathPlus + cartId);
                let data = await result.json();

                if (typeof data == 'object') {
                    let elHargaTotal = el.id == 'plus' ? el.parentElement.nextElementSibling
                        .nextElementSibling : el.parentElement.parentElement.nextElementSibling
                        .nextElementSibling;
                    let elJumlah = el.id == 'plus' ? el.previousElementSibling : el.parentElement
                        .previousElementSibling;
                    elJumlah.textContent = data.jumlah;
                    elHargaTotal.textContent =
                        `${formatRupiah((data.jumlah * data.produk.harga).toString(),'Rp. ')}`;

                    let subTotalVal = 0;
                    let beratTotalVal = 0;
                    for (let i = 0; i < elTbody.children.length; i++) {
                        const val = elTbody.children[i].children[4];
                        const jumlahBarang = val.previousElementSibling.previousElementSibling.children[1]
                            .textContent;
                        beratTotalVal += parseInt(val.id) * parseInt(jumlahBarang);
                        console.log(val);
                        subTotalVal += parseInt(val.textContent.split(' ')[1].replace(/\D/gi, ''));
                    }
                    subTotal.value = subTotalVal;
                    beratTotal.value = beratTotalVal;

                    const resModel = await fetch(pathModel);
                    let dataModel = await resModel.json();
                    model.value = JSON.stringify(dataModel);
                }
                if (data == 'stok_penuh') {
                    swal("Error", "Stok penuh!", "error");
                }
                if (data == 'error') {
                    swal("Error", "Data tidak ditemukan!", "error");
                }


            }

            // HANDLE BUTTON MINUS
            if (el.id == 'minus' || el.className.includes('fa-minus')) {
                let cartId = el.id == 'minus' ?
                    el.className.split(' ')[3] : el.parentElement.className.split(' ')[3];

                const result = await fetch(pathMinus + cartId);
                let data = await result.json();

                if (typeof data == 'object') {
                    let elHargaTotal = el.id == 'minus' ? el.parentElement.nextElementSibling
                        .nextElementSibling : el.parentElement.parentElement.nextElementSibling
                        .nextElementSibling;
                    let elJumlah = el.id == 'minus' ? el.nextElementSibling : el.parentElement
                        .nextElementSibling;
                    elJumlah.textContent = data.jumlah;
                    elHargaTotal.textContent =
                        `${formatRupiah((data.jumlah * data.produk.harga).toString(),'Rp. ')}`;

                    let subTotalVal = 0;
                    let beratTotalVal = 0;
                    for (let i = 0; i < elTbody.children.length; i++) {
                        const val = elTbody.children[i].children[4];
                        const jumlahBarang = val.previousElementSibling.previousElementSibling.children[1]
                            .textContent;
                        beratTotalVal += parseInt(val.id) * parseInt(jumlahBarang);
                        subTotalVal += parseInt(val.textContent.split(' ')[1].replace(/\D/gi, ''));
                    }
                    subTotal.value = subTotalVal;
                    beratTotal.value = beratTotalVal;

                    const resModel = await fetch(pathModel);
                    let dataModel = await resModel.json();
                    model.value = JSON.stringify(dataModel);
                }

                if (data == '0') {
                    let elTr = el.id == 'minus' ? el.parentElement.parentElement : el.parentElement
                        .parentElement.parentElement;
                    elTr.remove();
                }

                if (elTbody.children.length == 0) {
                    elTbody.innerHTML =
                        `<tr>
                        <td colspan="6" class="text-center">Data tidak ada!</td>
                    </tr>`;
                    tableRes.nextElementSibling.nextElementSibling.remove();
                }
            }


        });
    </script>
@endsection
