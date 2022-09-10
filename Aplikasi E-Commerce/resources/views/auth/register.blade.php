@extends('layouts.app')

@section('title', 'register')
@section('content')
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">

                                <div class="text-center">
                                    <h4>Register</h4>
                                </div>

                                <form class="mt-5 mb-5 login-input" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            name="nama" value="{{ old('nama') }}" id="nama"
                                            placeholder="Nama Lengkap *" required autocomplete="nama" autofocus>

                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" value="{{ old('email') }}" required autocomplete="off"
                                            placeholder="Email Address *" name="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" value="{{ old('no_hp') }}" required placeholder="628 NO HP *"
                                            name="no_hp">

                                        @error('no_hp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="jk"
                                            class="col-md-3 col-form-label">{{ __(' Jenis Kelamin') }}</label>
                                        <div class="col-md-9">
                                            <select name="jk" id="jk" class="form-control">
                                                <option value="laki-laki">Laki - laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <select name="province_id" class="form-control" required>
                                                <option value="">--Provinsi--</option>
                                                @foreach ($provinces as $province => $value)
                                                    <option value="{{ $province }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <select name="city_id" class="form-control" required>
                                                <option value="">--Kota--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" value="{{ old('alamat') }}"
                                            required rows="3" value="{{ old('alamat') }}" name="alamat" placeholder="Alamat Lengkap *"></textarea>

                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                placeholder="Password" required name="password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="password-confirmation"
                                                placeholder="Repeat Password" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn login-form__btn submit w-100">Sign Up</button>
                                </form>
                                <p class="mt-5 login-form__footer text-center">Have account <a href="{{ url('login') }}"
                                        class="text-primary">Sign In </a> now</p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select[name="province_id"]').on('change', function() {
                provinceId = $(this).val();
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
