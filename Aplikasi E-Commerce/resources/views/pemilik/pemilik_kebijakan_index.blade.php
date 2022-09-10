@extends('layouts.layout')

@section('title', 'Kebijakan')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar Kebijakan
            </h4>
            @php
                $authAkses = Auth::user()->akses;
            @endphp
            <a href="{{ url($authAkses . '/kebijakan/create') }}" class="btn btn-primary mb-3 mx-2">Buat
                Kebijakan</a>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Sub Judul</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->sub_judul }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <div class="row justify-content-around">
                                        <a href="{{ url($authAkses . '/kebijakan/' . $item->id . '/edit') }}"
                                            class="btn btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::open(['url' => $authAkses . '/kebijakan/' . $item->id, 'method' => 'DELETE']) !!}
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
        </div>
    </div>
@endsection
