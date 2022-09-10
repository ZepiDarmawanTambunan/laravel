@extends('layouts.layout')

@section('title', 'Laporan')
@section('subtitle', 'Pages')
@section('content')
    <div class="row mx-4">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mt-2 mb-3">
            <div class="card gradient-1">
                <div class="card-body">
                    <h4 class="card-title text-white">Pemasukan Harian</h4>
                    <br>
                    <div class="d-inline-block">
                        <h3 class="text-white">Rp. {{ number_format($pemasukan_harian) }}</h3>
                        <p class="text-white mb-0">{{ 
                            ($tgl_awal??null) ?
                            date('d-m-Y', strtotime($tgl_awal)).' - '.
                            date('d-m-Y', strtotime($tgl_akhir))
                            :
                            date('d-m-Y') }}</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mt-2 mb-3">
            <div class="card gradient-2">
                <div class="card-body">
                    <h4 class="card-title text-white">Pemasukan Bulanan</h4>
                    <div class="d-inline-block">
                        <h3 class="text-white">Rp. {{ number_format($pemasukan_bulanan) }}</h3>
                        <p class="text-white mb-0">{{ 
                            ($tgl_awal??null) ?
                            date('d-m-Y', strtotime($tgl_awal)).' - '.
                            date('d-m-Y', strtotime($tgl_akhir))
                            :
                            date('m-Y') }}</p>
                    </div>
                    <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mt-2 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ url(Auth::user()->akses . '/laporan/') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group p-0 m-0 mt-3">
                                        {!! Form::date('tgl_awal', $tgl_awal ?? \Carbon\Carbon::now()->startOfMonth(), [
                                            'class' => 'form-control',
                                            'autofocus',
                                            'required',
                                        ]) !!}
                                        <span class="text-helper">{{ $errors->first('tgl_awal') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-6">
                                    <div class="form-group p-0 m-0 mt-3">
                                        {!! Form::date('tgl_akhir', $tgl_akhir ?? \Carbon\Carbon::now()->endOfMonth(), [
                                            'class' => 'form-control',
                                            'autofocus',
                                            'required',
                                        ]) !!}
                                        <span class="text-helper">{{ $errors->first('tgl_akhir') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <button type="submit" class="btn py-2 btn-primary btn-block mt-3">submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card mb-4 mx-4 my-2">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Area Chart
            </h4>
            <div class="chart-area">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="myAreaChart" style="display: block; width: 486px; height: 320px;" width="486" height="320"
                    class="chartjs-render-monitor"></canvas>
            </div>
            <hr>
        </div>
    </div>

    <div class="card mb-4 mx-4 my-2">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Laporan Penjualan Dari
                {!!
                    ($tgl_awal??null) ?
                    date('d-m-Y', strtotime($tgl_awal)).' s/d '.
                    date('d-m-Y', strtotime($tgl_akhir))
                    :
                    \Carbon\Carbon::now()->startOfMonth()->format('d-m-Y').' s/d '.
                    \Carbon\Carbon::now()->endOfMonth()->format('d-m-Y')
                !!}
            </h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kode</th>
                            <th>Nama pelanggan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_pelanggan ?? $item->pelanggan->user->nama }}</td>
                                <td>Rp. {{ number_format($item->total) }}</td>
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
@endsection

@section('script')
    <script type="text/javascript">
        // var data akan digunakan pada chart-area-demo.js
        var data = {!! json_encode($data_area_chart) !!};
    </script>
    <!-- quixlab-main\theme\plugins\chart.js -->
    <script src="{{ asset('quixlab-main') }}/theme/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ asset('quixlab-main') }}/theme/js/plugins-init/chart-area-demo.js"></script>
@endsection
