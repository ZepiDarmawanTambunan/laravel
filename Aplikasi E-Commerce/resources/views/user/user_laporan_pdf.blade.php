<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PENJUALAN ANEKA TERPAL</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<style>
    .container-fluid {
        padding: 30px 100px 30px 100px;
    }

    p {
        margin: 0;
        padding: 0;
    }

    thead {
        border-top: 1px solid grey;
        border-bottom: 1px solid grey;
    }

    tbody {
        border-bottom: 1px solid grey;
    }

    td,
    th {
        width: 20.5%;
    }
</style>

<body class="bg-white">
    <div class="container-fluid bg-white">
        <div class="row">
            <div class="col">
                <h2>Aneka Terpal</h2>
                <p>Admin: {{ $penjualan->user->nama }} | {{$penjualan->user->no_hp}}</p>
            </div>
            <div class="col-2 offset-2">
                <p>Jambi, {{ $penjualan->created_at->format('d-m-Y') }}</p>
                <p>Kepada Yth:</p>
                <p>{{ $penjualan->nama_pelanggan }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <p>{{ $penjualan->kode }}</p>
            </div>

            <div class="col-2">
                <p>Diterima</p>
            </div>
        </div>

        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Jumlah Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Harga Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subTotal = 0;
                @endphp
                @foreach ($penjualanDetail as $item)
                    <tr>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->produk->kode_barang }}</td>
                        <td>{{ Str::limit($item->produk->nama, 25)}}</td>
                        <td>Rp. {{ number_format($item->produk->harga) }}</td>
                        <td>Rp. {{ number_format($item->produk->harga * $item->jumlah) }}</td>
                    </tr>
                    @php
                        $subTotal += $item->produk->harga * $item->jumlah;
                    @endphp
                @endforeach
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>******</td>
                    </tr>
                @endfor
                <tr>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col">
                <p>Barang telah diterima dengan baik dan cukup.</p>
            </div>
            <div class="col" style="margin-left: 440px;">
                <p>Sub total:<span style="margin-left: 20px;">Rp. {{ number_format($subTotal) }}</span></p>
                <p>Disc:<span style="margin-left: 50px;">{{ $penjualan->disc_point ?? '' }}</span></p>
                <hr style="border-top: 1px solid grey;">
                <p>Total:<span style="margin-left: 48px;">Rp. {{ number_format($penjualan->total) }}</span></p>
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-2">
                <p>Penerima,</p>
            </div>
            <div class="col">
                <p>Hormat Kami,</p>
            </div>
        </div>
    </div>
</body>
<script>
    let features = 'menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes';
    let url = 'http://localhost:8000/' + {!! json_encode(Auth::user()->akses) !!} +
        '/kasir';
    let win = window.open(url, '_blank', features);
    win.onload = function() {
        window.print();
    }
</script>

</html>
