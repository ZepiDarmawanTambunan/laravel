@extends('layouts.layout')

@section('title', 'Profile')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Profile</h4>

            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group text-center">
                    <img src="{{ $model->image == null ? asset('quixlab-main') . '/theme/images/user/form-user.png' : \Storage::url($model->image) }}"
                        style="height: 150px; width: 150px;" class="rounded-circle" alt="image {{ $model->name }}">
                    <br>
                    {!! Form::file('image', ['class' => 'btn btn-info mt-2 col-sm-4']) !!}
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    <label for="nama">nama <span class="text-danger">*</span></label>
                    {!! Form::text('nama', $model->nama, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>
                <div class="form-group">
                    <label for="email">email <span class="text-danger">*</span></label>
                    {!! Form::email('email', $model->email, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                    <label for="password">password lama (optional jika tidak diubah)</label>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'kosongkan jika tidak diubah']) !!}
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>
                <div class="form-group">
                    <label for="new_password">password baru (optional jika tidak
                        diubah)</label>
                    {!! Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'kosongkan jika tidak diubah']) !!}
                    <span class="text-danger">{{ $errors->first('new_password') }}</span>
                </div>
                <div class="form-group">
                    <label for="no_hp">no hp <span class="text-danger">*</span></label>
                    {!! Form::number('no_hp', $model->no_hp, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                </div>
                <div class="form-group row">
                    <label for="jk" class="col-md-3 col-form-label">{{ __(' Jenis Kelamin') }} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <select name="jk" id="jk" class="form-control" required>
                            <option value="laki-laki" {{ $model->pelanggan->jk == 'laki-laki' ? 'selected' : '' }}>Laki -
                                laki
                            </option>
                            <option value="perempuan" {{ $model->pelanggan->jk == 'perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                    </div>
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
                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                    </div>

                    <div class="col-md-6">
                        <label for="city_id">Kota Asal <span class="text-danger">*</span></label>
                        <select name="city_id" class="form-control" required>
                            <option value="">--Kota--</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    {!! Form::textarea('alamat', $model->alamat, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Ubah Data</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let cityId = {!! json_encode($city_id) !!}
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
