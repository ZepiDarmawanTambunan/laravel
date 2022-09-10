@extends('layouts.layout')

@section('title', 'Kasir')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            @php
                $authAkses = Auth::user()->akses;
            @endphp
            <h4 class="card-title mb-4">
                Kasir
            </h4>

            <form action="{{ url($authAkses . '/kasir/add') }}" method="POST" class="my-5">
                @csrf
                <div class="row align-items-center">
                    <div class="col-12 col-md-2 mb-2 mb-md-0">
                        <h5 class="fw-bold mb-0">Produk</h5>
                    </div>
                    <div class="col">
                        <input type="text" id="search" class="form-control">
                        <input type="hidden" name="produk_id" id="produk_id">
                    </div>
                    <div class="col-12 col-md-2 mt-2 mt-md-0">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>


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
                        @php
                            $subTotal = 0;
                        @endphp
                        @forelse ($model as $item)
                            @php
                                $hargaTotal = $item->produk->harga * $item->jumlah;
                                $subTotal += $hargaTotal;
                            @endphp
                            <tr>
                                <td>{{ $item->produk->kode_barang }}</td>
                                <td>{{ $item->produk->nama }}</td>
                                <td>
                                    <a href="" class="label gradient-2 btn-rounded {{$item->id}}" id="minus">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                    <span class="mx-3">{{ $item->jumlah }}</span>
                                    <a href="" class="label gradient-1 btn-rounded {{$item->id}}" id="plus">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </td>
                                <td>Rp. {{ number_format($item->produk->harga) }}</td>
                                <td>Rp. {{ number_format($hargaTotal) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ada!</td>
                            </tr>
                            <input style="display: none;" class="form-control" placeholder="Masukan Jumlah Discount (optional)" id="discount-input"
                            type="number" max="100" maxlength="3" name="disc_point" />
                            <p id="subTotal" style="display:none;">Total: Rp. {{ number_format($subTotal) }}</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <br>

            @if ($model->count() > 0)
                {!! Form::open(['url' => $authAkses . '/penjualan/', 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input class="form-control" placeholder="Masukan Nama pelanggan *" id="nama_pelanggan"
                                type="text" name="nama_pelanggan" required />
                            <span class="text-danger" style="font-size:12px;">{{ $errors->first('nama_pelanggan') }}</span>
                        </div>
                        <div class="form-group my-3">
                            <input class="form-control" placeholder="Masukan Jumlah Uang *" id="uang" type="text"
                                name="uang_penjualan" required />
                            <span class="text-danger" style="font-size:12px;">{{ $errors->first('uang_penjualan') }}</span>
                        </div>
                        <input class="form-control" placeholder="Masukan Jumlah Discount (optional)" id="discount-input"
                            type="number" max="100" maxlength="3" name="disc_point" />
                    </div>
                    <div class="col-md-3 offset-md-3">
                        <input type="hidden" name="total" id="hidden_total" value="{{ $subTotal }}">
                        <input type="hidden" name="model[]" value="{{ json_encode($model) }}" id="model">

                        <p id="subTotal">SubTotal: Rp. {{ number_format($subTotal) }}</p>
                        <p id="discount-text">Discount: 0%</p>
                        <p id="total">Total: Rp. {{ number_format($subTotal) }}</p>
                        <p id="kembalian">Kembalian: - Rp. {{ number_format($subTotal) }}</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2">
                    Submit
                </button>
                {!! Form::close() !!}
            @endif


        </div>
    </div>
@endsection

@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript">
        const input = document.querySelector('#uang');
        const discInput = document.querySelector('#discount-input');

        const subTotal = document.getElementById('subTotal');
        const discText = document.querySelector('#discount-text');
        const harga = document.getElementById('total');
        const kembalian = document.getElementById('kembalian');
        const hiddenTotal = document.getElementById('hidden_total');

        discInput.addEventListener('input', updateDiscount);
        let = hargaSplit = parseInt(subTotal.textContent.split(" ")[2].replace(/\D/gi,'')) ?? 0;

        function updateDiscount(e) { 
            let disc = e.target.value;
            hargaSplit = parseInt(subTotal.textContent.split(" ")[2].replace(/\D/gi,'')) ?? 0;

            if (disc >= 100) {
                discInput.value = 100;
                disc = 100;
            }

            if (disc < 0) {
                discInput.value = 0;
                disc = 0;
            }
            let res = hargaSplit * (disc / 100);
            // res = Math.round(res);

            const uang = input.value == "" ? 0 : parseInt(input.value.split(" ")[1].replace(/\D/gi,''));
            const countKembalian = uang - (hargaSplit - res);

            if (disc != "") {
                discText.textContent = "Discount: " + disc + "% => " + formatRupiah(res.toString(), 'Rp. ');
                harga.textContent = "Total: " + formatRupiah((hargaSplit - res).toString(), 'Rp. ');
                hiddenTotal.value = hargaSplit - res;

                kembalian.textContent = (countKembalian <
                        0) ? `Kembalian: - ${formatRupiah(countKembalian.toString(), 'Rp. ')}` :
                    `Kembalian: ${formatRupiah(countKembalian.toString(), 'Rp. ')}`;
            } else {
                discText.textContent = "Discount: 0%";
                harga.textContent = "Total: " + formatRupiah((hargaSplit - res).toString(), 'Rp. ');
                hiddenTotal.value = hargaSplit - res;

                kembalian.textContent = (countKembalian <
                        0) ? `Kembalian: - ${formatRupiah(countKembalian.toString(), 'Rp. ')}` :
                    `Kembalian: ${formatRupiah(countKembalian.toString(), 'Rp. ')}`;
            }

        }

        // HANDLE TOTAL - KEMBALIAN
        if(input != null){
            input.addEventListener('input', updateKembalian);
        }

        function updateKembalian(e) {
            input.value = formatRupiah(e.target.value, "Rp. ");
            const total = harga.textContent.split(" ")[2].replace(/\D/gi,'');
            const check = e.target.value == "" ? 0 : e.target.value.split(" ")[1].replace(/\D/gi,'');
            const totalKembalian = parseInt(check) - total;
            kembalian.textContent =
                `Kembalian: ${totalKembalian < 0 ? '- '+formatRupiah(totalKembalian.toString(), 'Rp. '): formatRupiah(totalKembalian.toString(), 'Rp. ')}`;
        }

        // HANDLE SEARCH
        const path = "kasir/search/";
        $("#search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: path+request.term,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        console.log(data);
                        data = data.map(e => {
                            return {
                                value: e.kode_barang + ' - ' + e.value,
                                kode_barang: e.kode_barang,
                                produk_id: e.id,
                            }
                        });
                        response(data);
                    },
                    error: function(err){
                        console.log(err);
                    }
                });
            },
            select: function(event, ui) {
                $('#produk_id').val(ui.item.produk_id);
                $('#search').val(ui.item.label);
                return false;
            }
        });

        // HANDLE BUTTON PLUS AND MINUS
        const tableRes = document.querySelector('.table-responsive');
        const pathPlus = "kasir/plus/";
        const pathMinus = "kasir/minus/";
        
        tableRes.addEventListener('click', async function(e){
            e.preventDefault();
            let el = e.target;
            let elTbody = tableRes.children[0].children[1];
            const pathModel = "kasir/getModel";
            const model = document.getElementById('model');
            
            // HANDLE BUTTON PLUS
            if(el.id == 'plus' || el.className.includes('fa-plus')){
                let cartId = el.id == 'plus' ? 
                el.className.split(' ')[3] : el.parentElement.className.split(' ')[3];
                
                const result = await fetch(pathPlus+cartId);
                let data = await result.json();
                
                if(typeof data == 'object'){
                    let elHargaTotal = el.id == 'plus' ? el.parentElement.nextElementSibling.nextElementSibling : el.parentElement.parentElement.nextElementSibling.nextElementSibling;
                    let elJumlah = el.id == 'plus' ? el.previousElementSibling : el.parentElement.previousElementSibling;
                    elJumlah.textContent = data.jumlah;
                    elHargaTotal.textContent = `${formatRupiah((data.jumlah * data.produk.harga).toString(),'Rp. ')}`;
                    
                    let subTotalVal = 0;
                    for (let i = 0; i < elTbody.children.length; i++) {
                        const val = elTbody.children[i].children[4];
                        
                        subTotalVal += parseInt(val.textContent.split(' ')[1].replace(/\D/gi,''));
                    }

                    hiddenTotal.value = subTotalVal;
                    subTotal.textContent = `SubTotal: ${formatRupiah(subTotalVal.toString(), 'Rp. ')}`;
                    // cek discount nya berapa dan uang pembayaran nya berapa
                    const uang = input.value == "" ? 0 : input.value.split(' ')[1].replace(/\D/gi,'');
                    const disc = discInput.value == "" ? 0 : parseInt(discInput.value);
                    const total = subTotalVal - (subTotalVal * (disc/100));
                    const kembalianVal = parseInt(uang) - total;
                    discText.textContent = disc > 0 ? `Discount: ${disc}% => ${formatRupiah((subTotalVal * (disc/100)).toString(), 'Rp. ')}` 
                    : `Discount: ${disc}%`;
                    harga.textContent = `Total: ${formatRupiah(total.toString(), 'Rp. ')}`;
                    kembalian.textContent = kembalianVal < 0 ? 
                    'Kembalian: - '+ formatRupiah(kembalianVal.toString(), 'Rp. ')
                    : 
                    'Kembalian: '+ formatRupiah(kembalianVal.toString(), 'Rp. ');

                    const resModel = await fetch(pathModel);
                    let dataModel = await resModel.json();
                    model.value = JSON.stringify(dataModel);
                    console.log(JSON.stringify(dataModel));
                }
                if(data == 'stok_penuh'){
                    swal("Error", "Stok penuh!", "error");
                }
                if(data == 'error'){
                    swal("Error", "Data tidak ditemukan!", "error");
                }
            }

            // HANDLE BUTTON MINUS
            if(el.id == 'minus' || el.className.includes('fa-minus')){
                let cartId = el.id == 'minus' ? 
                el.className.split(' ')[3] : el.parentElement.className.split(' ')[3];
                
                const result = await fetch(pathMinus+cartId);
                let data = await result.json();
            
                if(typeof data == 'object'){
                    let elHargaTotal = el.id == 'minus' ? el.parentElement.nextElementSibling.nextElementSibling : el.parentElement.parentElement.nextElementSibling.nextElementSibling;
                    let elJumlah = el.id == 'minus' ? el.nextElementSibling : el.parentElement.nextElementSibling;
                    elJumlah.textContent = data.jumlah;
                    elHargaTotal.textContent = `${formatRupiah((data.jumlah * data.produk.harga).toString(),'Rp. ')}`;
                }

                if(data == '0'){
                    let elTr = el.id == 'minus' ? el.parentElement.parentElement : el.parentElement.parentElement.parentElement;
                    elTr.remove();
                }

                let subTotalVal = 0;
                for (let i = 0; i < elTbody.children.length; i++) {
                    const val = elTbody.children[i].children[4];
                    
                    subTotalVal += parseInt(val.textContent.split(' ')[1].replace(/\D/gi,''));
                }

                hiddenTotal.value = subTotalVal;
                subTotal.textContent = `SubTotal: ${formatRupiah(subTotalVal.toString(), 'Rp. ')}`;
                // cek discount nya berapa dan uang pembayaran nya berapa
                const uang = input.value == "" ? 0 : input.value.split(' ')[1].replace(/\D/gi,'');
                const disc = discInput.value == "" ? 0 : parseInt(discInput.value);
                const total = subTotalVal - (subTotalVal * (disc/100));
                const kembalianVal = parseInt(uang) - total;

                discText.textContent = disc > 0 ? `Discount: ${disc}% => ${formatRupiah((subTotalVal * (disc/100)).toString(), 'Rp. ')}` 
                : `Discount: ${disc}%`;
                harga.textContent = `Total: ${formatRupiah(total.toString(), 'Rp. ')}`;
                kembalian.textContent = kembalianVal < 0 ? 
                'Kembalian: - '+ formatRupiah(kembalianVal.toString(), 'Rp. ')
                : 
                'Kembalian: '+ formatRupiah(kembalianVal.toString(), 'Rp. ');

                const resModel = await fetch(pathModel);
                let dataModel = await resModel.json();
                model.value = JSON.stringify(dataModel);
                console.log(JSON.stringify(dataModel));

                if(elTbody.children.length == 0){
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
