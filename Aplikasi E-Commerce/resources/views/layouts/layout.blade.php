<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title', 'Beranda')</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('quixlab-main') }}/theme/images/favicon.png">

    <!-- Styles -->

    <link href="{{ asset('quixlab-main') }}/theme/css/style.css" rel="stylesheet">
    {{-- dipakai utk confirm delete --}}

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    @yield('head')
</head>

<body>

    @php
        $auth = Auth::user();
        $authAkses = $auth->akses;
        $authId = $auth->id;

        $form_search = '';
        if (Request::is($authAkses . '/penjualan*') || Request::is($authAkses . '/pencarian/penjualan*')) {
            $form_search = url($authAkses . '/pencarian/penjualan');
        } elseif (Request::is($authAkses . '/pembayaran*') || Request::is($authAkses . '/pencarian/pembayaran*')) {
            $form_search = url($authAkses . '/pencarian/pembayaran');
        } elseif (Request::is($authAkses . '/pengiriman*') || Request::is($authAkses . '/pencarian/pengiriman*')) {
            $form_search = url($authAkses . '/pencarian/pengiriman');
        } elseif (Request::is('pelanggan/pesanan*') || Request::is($authAkses . '/pencarian/pesanan*')) {
            $form_search = url($authAkses . '/pencarian/pesanan');
        } else {
            $form_search = url($authAkses . '/pencarian/produk');
        }
    @endphp

    <div id="main-wrapper">
        <!--**********************************
        Nav header start
    ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ url($authAkses . '/beranda') }}">
                    <b class="logo-abbr"><img src="{{ asset('quixlab-main') }}/theme/images/logo.png" alt="">
                    </b>
                    <span class="logo-compact"><img src="{{ asset('quixlab-main') }}/theme/images/logo-compact.png"
                            alt=""></span>
                    <span class="brand-title">
                        <h3 class="text-white">Aneka Terpal</h3>
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
        Nav header end
    ***********************************-->

        <!--**********************************
        Header start
    ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <form action="{{ $form_search }}" method="GET" class="mb-5 login-input">
                        <div class="input-group icons">
                            <div class="input-group-prepend">
                                <button type="submit" class="input-group-text bg-transparent border-0 pr-2 pr-sm-3"
                                    id="basic-addon1"><i class="mdi mdi-magnify"></i></button>
                            </div>
                            <input type="search" class="form-control" placeholder="Search Dashboard"
                                aria-label="Search Dashboard" name="query">
                        </div>
                    </form>
                </div>

                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="mr-2">{{Auth::user()->nama}}</div>
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ Auth::user()->image == null ? asset('quixlab-main') . '/theme/images/user/form-user.png' : \Storage::url(Auth::user()->image) }}" height="40"
                                    width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ url($authAkses . '/profile/' . $authId . '/edit') }}">
                                                <i class="icon-user"></i><span>Profile</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><i
                                                    class="icon-key"></i> <span>Logout</span></a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
        Header end ti-comment-alt
    ***********************************-->

        <!--**********************************
        Sidebar start
    ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Dashboard</li>
                    <li class="nav-item {{ request()->is($authAkses . '/beranda*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url($authAkses . '/beranda') }}" aria-expanded="false">
                            <i class="fa fa-tachometer" aria-hidden="true"></i><span class="nav-text">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-label">Pages</li>

                    <li class="nav-item {{ Request::is($authAkses . '/profile*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url($authAkses . '/profile/' . $authId . '/edit') }}"
                            aria-expanded="false"><i class="fa fa-user"></i>
                            <span class="nav-text">Profile</span>
                        </a>
                    </li>

                    @if ($authAkses == 'pelanggan')
                        <li
                            class="nav-item {{ Request::is('pelanggan/produk*') || Request::is('pelanggan/keranjang*') || Request::is('pelanggan/pencarian/produk*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pelanggan/produk') }}" aria-expanded="false"><i
                                    class="fa fa-shopping-basket"></i>
                                <span class="nav-text">Produk</span>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ Request::is('pelanggan/pesanan*') || Request::is('pelanggan/pembayaran*') || Request::is('pelanggan/pencarian/pesanan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pelanggan/pesanan') }}" aria-expanded="false">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="nav-text">Pesanan</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('pelanggan/hubungikami*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pelanggan/hubungikami') }}" aria-expanded="false">
                                <i class="fa fa-phone-square"></i>
                                <span class="nav-text">Hubungi Kami</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('pelanggan/kebijakan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pelanggan/kebijakan') }}" aria-expanded="false">
                                <i class="fa fa-clipboard"></i>
                                <span class="nav-text">Kebijakan</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('pelanggan/tentangkami*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pelanggan/tentangkami') }}" aria-expanded="false">
                                <i class="fa fa-users"></i>
                                <span class="nav-text">Tentang Kami</span>
                            </a>
                        </li>
                    @endif

                    @if ($authAkses == 'admin' || $authAkses == 'pemilik')
                        <li class="nav-item {{ Request::is($authAkses . '/user*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/user') }}" aria-expanded="false">
                                <i class="fa fa-user-plus"></i>
                                <span class="nav-text">Users</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Request::is($authAkses . '/produk*') || Request::is($authAkses . '/keranjang*') || Request::is($authAkses . '/pencarian/produk*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/produk') }}" aria-expanded="false">
                                <i class="fa fa-shopping-basket"></i>
                                <span class="nav-text">Produk</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is($authAkses . '/kasir*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/kasir') }}" aria-expanded="false">
                                <i class="fa fa-calculator"></i>
                                <span class="nav-text">Kasir</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is($authAkses . '/diskon*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/diskon') }}" aria-expanded="false">
                                <i class="fa fa-gift"></i>
                                <span class="nav-text">Diskon</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Request::is($authAkses . '/penjualan*') || Request::is($authAkses . '/pencarian/penjualan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/penjualan') }}" aria-expanded="false">
                                <i class="fa fa-calculator"></i>
                                <span class="nav-text">Penjualan</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Request::is($authAkses . '/pembayaran*') || Request::is($authAkses . '/pembayaran*') || Request::is($authAkses . '/pencarian/pembayaran*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/pembayaran') }}" aria-expanded="false">
                                <i class="fa fa-credit-card"></i>
                                <span class="nav-text">Pembayaran</span>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ Request::is($authAkses . '/pengiriman*') || Request::is($authAkses . '/pengiriman*') || Request::is($authAkses . '/pencarian/pengiriman*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/pengiriman') }}" aria-expanded="false">
                                <i class="fa fa-truck"></i>
                                <span class="nav-text">Pengiriman</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is($authAkses . '/kebijakan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url($authAkses . '/kebijakan') }}" aria-expanded="false">
                                <i class="fa fa-clipboard"></i>
                                <span class="nav-text">Kebijakan</span>
                            </a>
                        </li>
                    @endif

                    @if ($authAkses == 'pemilik')
                        <li class="nav-item {{ Request::is('pemilik/rekening*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pemilik/rekening') }}" aria-expanded="false">
                                <i class="fa fa-credit-card"></i>
                                <span class="nav-text">Kelola
                                    Rekening</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('pemilik/laporan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('pemilik/laporan') }}" aria-expanded="false">
                                <i class="fa fa-file"></i>
                                <span class="nav-text">Laporan</span>
                            </a>
                        </li>
                    @endif

                    {{-- <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-notebook menu-icon"></i><span class="nav-text">Pages</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page-login.html">Login</a></li>
                            <li><a href="./page-register.html">Register</a></li>
                            <li><a href="./page-lock.html">Lock Screen</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                                <ul aria-expanded="false">
                                    <li><a href="./page-error-404.html">Error 404</a></li>
                                    <li><a href="./page-error-403.html">Error 403</a></li>
                                    <li><a href="./page-error-400.html">Error 400</a></li>
                                    <li><a href="./page-error-500.html">Error 500</a></li>
                                    <li><a href="./page-error-503.html">Error 503</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        </div>
        <!--**********************************
        Sidebar end
    ***********************************-->

        <!--**********************************
        Content body start
    ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">@yield('subtitle', 'Dashboard')</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">@yield('title', 'Beranda')</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                @include('sweetalert::alert')
                @yield('content')
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
        Content body end
    ***********************************-->


        <!--**********************************
        Footer start
    ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a>
                    2018</p>
            </div>
        </div>
        <!--**********************************
        Footer end
    ***********************************-->
    </div>

    {{-- ini untuk sweet alert confirm delete di kelas_index dan materi_index --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    {{-- end --}}
    <script src="{{ asset('quixlab-main') }}/theme/plugins/common/common.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/custom.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/settings.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/gleek.js"></script>
    <!-- <script src="{{ asset('quixlab-main') }}/theme/js/styleSwitcher.js"></script> -->

    <script type="text/javascript">
        // FORMAT RUPIAH
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }

        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Apakah kamu yakin hapus ?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
    @yield('script')
</body>

</html>
