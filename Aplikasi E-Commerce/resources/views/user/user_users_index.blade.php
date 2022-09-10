@extends('layouts.layout')

@section('title', 'Users')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Daftar {{ $authAkses == 'pemilik' ? 'Users' : 'Pelanggan' }}
            </h4>

            <a href="{{ url($authAkses . '/user/create?akses=pelanggan') }}" class="btn btn-primary mb-3 mr-2">Buat
                Akun
                pelanggan</a>

            @if ($authAkses == 'pemilik')
                <a href="{{ url('pemilik/user/create?akses=admin') }}" class="btn btn-primary mb-3 mx-2">Buat Akun
                    admin</a>
            @endif


            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Akses</th>
                            <th>Tanggal Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($model as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->akses }}
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <div class="row justify-content-around">
                                        <a href="{{ url($authAkses . '/user/' . $item->id . '/edit') }}"
                                            class="btn btn-warning"><i class="fa fa-pencil-square-o"></i></a>
                                        {!! Form::open(['url' => $authAkses . '/user/' . $item->id, 'method' => 'DELETE']) !!}
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
            <div class="d-flex justify-content-center mt-2">
                {{ $model->links() }}
            </div>
        </div>
    </div>
@endsection
