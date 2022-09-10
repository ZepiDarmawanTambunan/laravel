<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aneka Terpal</title>

    <!-- Fonts -->
    <link href="{{ asset('quixlab-main') }}/theme/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css">

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('quixlab-main') }}/theme/images/favicon.png">

    <!-- Styles -->
    <link href="{{ asset('quixlab-main') }}/theme/css/style.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        .nav-item:hover {
            font-weight: bold;
            transition: 1s;
        }

        .wrapper {
            background-image: url('/quixlab-main/theme/images/store_9.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            width: 100%;
            background-position: center;
            height: 80vh;
        }

        .box-1 {
            background-size: cover;
            width: 100%;
            background-position: center;
            height: 40vh;
        }

        .text-heading {
            margin-left: 100px;
            margin-top: 150px;
            width: fit-content;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .text-1 {
            font-size: 45px;
            text-decoration: underline;
        }

        .text-2 {
            font-size: 46px;
            line-height: 50px;
        }

        .text-3 {
            font-size: 50px;
        }


        body {
            overflow-x: hidden;
        }

        @media only screen and (max-width: 1150px) {
            .text-1 {
                font-size: 30px;
            }

            .text-2 {
                font-size: 20px;
                line-height: 20px;
            }

            .text-3 {
                font-size: 20px;
            }

            .box-1 {
                height: 50vh;
            }

            .text-heading {
                font-size: 28px;
            }
        }

        @media only screen and (max-width: 600px) {
            .wrapper {
                height: 300px;
            }

            .text-heading {
                margin-left: 30px;
                margin-top: 60px;
                background-color: rgba(0, 0, 0, 0.2);
                font-size: 18px;
            }

            .box-1 {
                height: 55vh;
            }
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark py-3"
        style="position: relative;background-color: #8EC5FC;
    background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    ">
        <a class="navbar-brand" href="{{ url('/') }}">
            Aneka Terpal
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto mt-lg-0 mt-4">
                <a class="nav-item nav-link text-white" href="{{ url('/login') }}">Login</a>
                <a class="nav-item nav-link text-white mr-md-5" href="{{ url('/register') }}">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="row mx-0">
        <div class="wrapper">
            <h1 class="text-white text-heading rounded" style="width: 40vw;">
                Aneka Terpal Menjual Berbagai Terpal Sesuai Dengan Keinginan Pelanggan
            </h1>
        </div>
    </div>

    <h1 class="mt-3 text-center my-4 text-secondary">CONTOH TERPAL</h1>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_mobil.jpg') }}" alt="gambar"
                            class="img-fluid mb-3">
                        <p class="card-title text-center">Terpal Tutup Truk</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_bulat.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Terpal Kolam Bulat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_kandang.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Terpal Kandang Ayam</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_tambak.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Kolam Pertambakan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_jemur.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Jemur Padi</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_bangunan.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Terpal Penutup Bangunan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_alas.jpg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Terpal Alas</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('quixlab-main/theme/images/default/terpal_pakai.jpeg') }}" alt="gambar"
                            class="img-fluid mb-3" style="background-size: cover; background-position: center;">
                        <p class="card-title text-center">Terpal Siap Pakai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mx-0">
        <div class="box-1 text-center p-3"
            style="background-color: #A9C9FF;
        background-image: linear-gradient(91deg, #A9C9FF 0%, #FFBBEC 100%);
        ">
            <h1 class="text-white">DAPATKAN TERPAL DENGAN BERBAGAI UKURAN</h1>
            <a href="{{ 'https://api.whatsapp.com/send?phone=' . ($pemilik->no_hp ?? '081994466852') . '&text=Saya%20mau%20cari%20terpal' }}"
                class="btn btn-success p-3 mt-3">WA CS 1: {{ '+'.$pemilik->no_hp ?? '081994466852' }}</a><br>
            <a href="{{ 'https://api.whatsapp.com/send?phone=' . ($admin1->no_hp ?? '085943507666') . '&text=Saya%20mau%20cari%20terpal' }}"
                class="btn btn-success p-3 mt-3">WA CS 2: {{ '+'.$admin1->no_hp ?? '085943507666' }}</a>
        </div>
    </div>

    <h1 class="my-5 text-center text-secondary font-weight-bold">ANEKA TERPAL, SOLUSI TERPAL ANDA</h1>

    <div class="row mx-0">
        <div class="bg-dark w-100">
            <div class="row text-white p-5">
                <div class="col-12 col-md">
                    <p>ALAMAT KAMI</p>
                    <hr>
                    <p>
                        {{ $pemilik->nama ?? 'Aneka Terpal' }}
                        <br>
                        {{ $pemilik->alamat ?? 'Jl. Dharmapala, Kb. IX, Kec. Sungai Gelam, Kabupaten Muaro Jambi, Jambi 36374' }}
                        <br>
                        <br>
                        Operasional:
                        <br>
                        Senin – Jumat: 08.00-17.00 WIB
                        <br>
                        Sabtu 08.00-17.00 WIB
                        <br>
                        Minggu dan Hari Libur Tutup
                    </p>
                </div>

                <div class="col-12 col-md">
                    <p>KONTAK KAMI</p>
                    <hr>
                    <p>
                        Phone: {{ '+'.$pemilik->no_hp }}
                        <br>
                        Whatsapp:
                        <br>
                        CS 1: {{ '+'.$pemilik->no_hp ?? '081994466852' }}
                        <br>
                        CS 2: {{ '+'.$admin1->no_hp ?? '085943507666' }}
                        <br>
                        Email: {{ $pemilik->email }}
                    </p>
                </div>
                <div class="col-12 col-md">
                    <p>@2022 {{ $pemilik->nama ?? 'PT Aneka Terpal' }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('quixlab-main') }}/theme/plugins/common/common.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/custom.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/settings.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/gleek.js"></script>
</body>

</html>
