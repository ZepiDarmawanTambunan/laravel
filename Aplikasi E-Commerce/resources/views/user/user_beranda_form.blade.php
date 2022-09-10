@extends('layouts.layout')

@section('title', 'Beranda')
@section('subtitle', 'Dashboard')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Ubah Beranda {{ $status }}
            </h4>

            <div class="basic-form">
                <form action="{{ url(Auth::user()->akses . '/beranda/') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="judul">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul"
                            value="{{ $model->judul ?? '' }}" required>
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('judul') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="sub_judul">Sub Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="sub_judul" name="sub_judul"
                            value="{{ $model->sub_judul ?? '' }}" required>
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('sub_judul') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="video">Link Video <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="video" name="video"
                            value="{{ $model->video ?? '' }}" required>
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('video') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar</label>
                        {!! Form::file('image', ['class' => 'btn border mt-2 col-sm-4 col-md-12']) !!}
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('image') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                        <textarea id="deskripsi" class="form-control" rows="3" name="deskripsi" required>{{ $model->deskripsi ?? '' }}</textarea>
                        <span class="text-danger" style="font-size:12px;">{{ $errors->first('deskripsi') }}</span>
                    </div>

                    <input type="hidden" value="{{ $status }}" name="status" required>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript"></script>
@endsection
