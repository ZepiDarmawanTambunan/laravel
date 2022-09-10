@extends('layouts.layout')

@section('title', 'Kebijakan')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                {{ $method === 'POST' ? 'Buat' : 'Ubah' }} Kebijakan
            </h4>
            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group">
                    <label for="judul">Judul <span class="text-danger">*</span></label>
                    {!! Form::text('judul', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('judul') }}</span>
                </div>
                <div class="form-group">
                    <label for="sub_judul">Sub Judul <span class="text-danger">*</span></label>
                    {!! Form::text('sub_judul', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('sub_judul') }}</span>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                    {!! Form::textarea('deskripsi', null, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mt-2">{{ $namaTombol }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
