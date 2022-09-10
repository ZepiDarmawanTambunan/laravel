@extends('layouts.layout')


@section('title', 'Beranda')
@section('subtitle', 'Dashboard')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            @php
                $authAkses = Auth::user()->akses;
            @endphp
            <h4 class="card-title mb-4">Dashboard</h4>

            @if ($authAkses == 'pemilik')
                <div class="d-flex flex-column flex-lg-row">
                    <div class="text-center text-lg-left">
                        <a href="{{ url('/pemilik/beranda/pemilik') }}" class="btn btn-primary">Ubah Beranda Pemilik</a>
                    </div>
                    <div class="my-2 my-lg-0 mx-lg-3 text-center text-lg-left">
                        <a href="{{ url('/pemilik/beranda/admin') }}" class="btn btn-primary">Ubah Beranda Admin</a>
                    </div>
                    <div class="text-center text-lg-left">
                        <a href="{{ url('/pemilik/beranda/pelanggan') }}" class="btn btn-primary">Ubah Beranda
                            Pelanggan</a>
                    </div>
                </div>
            @endif
            @if ($authAkses == 'admin')
                <div class="text-center text-lg-left">
                    <a href="{{ url('/admin/beranda/pelanggan') }}" class="btn btn-primary">Ubah Beranda
                        Pelanggan</a>
                </div>
            @endif
            <hr>
            <p class="text-center">{{ $model->judul ?? 'Selamat Datang ' . $akses }}</p class="text-center">
            <hr>
            <p class="text-dark my-3 text-justify">
                {{ $model->sub_judul ??
                    'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere optio
                                                                                                                                                                                                                                                                                                                                            reprehenderit
                                                                                                                                                                                                                                                                                                                                            qui,
                                                                                                                                                                                                                                                                                                                                            minus quas sit nam libero molestiae blanditiis iste accusantium numquam odit magni, ut velit autem omnis
                                                                                                                                                                                                                                                                                                                                            pariatur hic.' }}
            </p>
            <div class="row">
                <div class="col-xl-6 col-md-12 my-2">
                    <img style="background-repeat: no-repeat; background-position:center;" width="100%" height="315"
                        src="{{ $model->image == null ? asset('quixlab-main') . '/theme/images/default/alert.jpg' : \Storage::url($model->image) }}"
                        alt="Card image cap">
                </div>
                <div class="col-xl-6 col-md-12 my-2">
                    {!! $model->video ??
                        '                    <iframe width="560" height="315" src="https://www.youtube.com/embed/V2VmcuOEqEg"
                                                                                                                                                                                                                                                                                                                                                                                                                            title="YouTube video player" frameborder="0"
                                                                                                                                                                                                                                                                                                                                                                                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                                                                                                                                                                                                                                                                                                                                                                            allowfullscreen></iframe>' !!}
                </div>
            </div>
            <p class="text-justify">
                {{ $model->deskripsi ??
                    'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente labore possimus
                                                                                                                                                                                                                                                                                                                        veniam ut inventore libero
                                                                                                                                                                                                                                                                                                                        nobis officia eveniet error nesciunt nemo dicta autem fuga fugiat asperiores neque numquam, cupiditate
                                                                                                                                                                                                                                                                                                                        delectus illo tenetur dignissimos perferendis pariatur eum. Itaque sint qui ipsa asperiores error, dolor,
                                                                                                                                                                                                                                                                                                                        maiores, hic veritatis impedit facere officiis iure.' }}
            </p>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        let iframe = document.querySelector('iframe');
        iframe.style.width = '100%';
    </script>
@endsection
