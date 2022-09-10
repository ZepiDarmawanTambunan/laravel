@extends('layouts.layout')

@section('title', 'Diskon')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">
                {{ $method === 'POST' ? 'Buat' : 'Ubah' }} Diskon
            </h4>

            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group">
                    <label for="kode">Kode Diskon <span class="text-danger">*</span></label>
                    {!! Form::text('kode', \Str::random(6), ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('kode') }}</span>
                </div>

                <div class="form-group">
                    <label for="poin">Poin <span class="text-danger">*</span></label>
                    {!! Form::number('poin', $model->poin, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('poin') }}</span>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                    {!! Form::number('jumlah', $model->jumlah, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                </div>
                <div class="form-group">
                    <label for="gratis_ongkir">Gratis Ongkir <span class="text-danger">*</span></label>
                    <select class="form-control" name="gratis_ongkir" required>
                        <option value="yes" {{ $model->gratis_ongkir == 'yes' ? 'selected' : '' }}>Iya
                        </option>
                        <option value="no" {{ $model->gratis_ongkir == 'no' ? 'selected' : '' }}>
                            Tidak
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tgl_berakhir">Tanggal berakhir: <span class="text-danger">*</span></label>
                    {!! Form::datetimeLocal('tgl_berakhir', $model->tgl_berakhir ?? '', [
                        'class' => 'form-control',
                        'autofocus',
                        'required',
                    ]) !!}
                    <span class="text-danger">{{ $errors->first('tgl_berakhir') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mt-2">{{ $namaTombol }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
