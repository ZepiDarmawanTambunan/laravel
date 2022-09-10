@extends('layouts.layout')

@section('title', 'Diskon')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar Diskon
            </h4>
            @php
                $authAkses = Auth::user()->akses;
            @endphp
            <a href="{{ url($authAkses . '/diskon/create') }}" class="btn btn-primary mb-2 mb-4 mx-2">Buat
                Diskon</a>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Poin</th>
                            <th>Jumlah</th>
                            <th>Gratis Ongkir</th>
                            <th>Tanggal Berakhir</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->poin }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->gratis_ongkir }}</td>
                                <td>{{ date('Y-m-d', strtotime($item->tgl_berakhir ?? date('Y-m-d'))) }}</td>
                                <td>{{ $item->user->nama }}</td>
                                <td>
                                    <div class="row justify-content-around">
                                        <a href="{{ url($authAkses . '/diskon/' . $item->id . '/edit') }}"
                                            class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::open(['url' => $authAkses . '/diskon/' . $item->id, 'method' => 'DELETE']) !!}
                                        <button type="submit" class="btn btn-danger show_confirm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ada!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (isset($model))
                <div class="d-flex justify-content-center mt-2">
                    {{ $model->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
