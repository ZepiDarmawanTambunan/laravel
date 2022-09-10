@extends('layouts.layout')

@section('title', 'Rekening')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                {{ $method === 'POST' ? 'Buat' : 'Ubah' }} Rekening
            </h4>
            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group">
                    <label for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
                    {!! Form::text('nama_bank', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-helper">{{ $errors->first('nama_bank') }}</span>
                </div>
                <div class="form-group">
                    <label for="nomor_rekening">Nomor Rekening <span class="text-danger">*</span></label>
                    {!! Form::number('nomor_rekening', null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-helper">{{ $errors->first('nomor_rekening') }}</span>
                </div>
                <div class="form-group">
                    <label for="nama_pemilik">Nama Pemilik <span class="text-danger">*</span></label>
                    {!! Form::text('nama_pemilik', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-helper">{{ $errors->first('nama_pemilik') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mt-2">{{ $namaTombol }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
