@extends('layouts.layout')

@section('title', 'Profile')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2">
        <div class="card-body">
            <h4 class="card-title mb-4">Profile</h4>

            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group text-center">
                    <img src="{{ $model->image == null ? asset('quixlab-main') . '/theme/images/user/form-user.png' : \Storage::url($model->image) }}"
                        style="height: 150px; width: 150px;" class="img-fluid rounded-circle" alt="image {{ $model->name }}">
                    <br>
                    {!! Form::file('image', ['class' => 'btn btn-info mt-2 col-sm-4']) !!}
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    <label for="nama">nama <span class="text-danger">*</span></label>
                    {!! Form::text('nama', $model->nama, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>
                <div class="form-group">
                    <label for="email">email <span class="text-danger">*</span></label>
                    {!! Form::email('email', $model->email, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>

                <div class="form-group">
                    <label for="password">password <i>(opsi kosongkan jika tidak diubah)</i></label>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'kosongkan jika tidak diubah']) !!}
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>

                <div class="form-group">
                    <label for="no_hp">no hp <span class="text-danger">*</span></label>
                    {!! Form::number('no_hp', $model->no_hp, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="province_id">Provinsi Asal <span class="text-danger">*</span></label>
                        <select name="province_id" class="form-control" required>
                            <option value="">--Provinsi--</option>
                            @foreach ($provinces as $province => $value)
                                <option value="{{ $province }}" {{ $province == $province_id ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('city_id') }}</span>
                    </div>

                    <div class="col-md-6">
                        <label for="city_id">Kota Asal <span class="text-danger">*</span></label>
                        <select name="city_id" class="form-control" required>
                            <option value="">--Kota--</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('city_id') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    {!! Form::textarea('alamat', $model->alamat, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Tentang Kami <span class="text-danger">*</span></label>
                    {!! Form::textarea('deskripsi', $model->pemilik->deskripsi, [
                        'class' => 'form-control',
                        'rows' => 3,
                        'required',
                    ]) !!}
                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                </div>

                <div class="form-group">
                    <label for="peta_gmap">Link Peta Gmap <span class="text-danger">*</span></label>
                    {!! Form::textarea('peta_gmap', $model->pemilik->peta_gmap, [
                        'class' => 'form-control',
                        'rows' => 3,
                        'required',
                    ]) !!}
                    <span class="text-danger">{{ $errors->first('peta_gmap') }}</span>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Ubah Data</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let cityId = {!! json_encode($city_id) !!}
        $(document).ready(function() {

            let provinceId = $('select[name="province_id"]').val();
            if (provinceId) {
                jQuery.ajax({
                    url: '/province/' + provinceId + '/cities',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('select[name="city_id"]').empty();
                        $.each(data, function(key, value) {
                            if (key == cityId) {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '" selected>' + value +
                                    '</option>');
                            } else {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            }
                        });
                    }
                });
            }

            $('select[name="province_id"]').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    jQuery.ajax({
                        url: '/province/' + provinceId + '/cities',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);

                            $('select[name="city_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="city_origin"]').empty();
                }
            });
        });
    </script>
@endsection
