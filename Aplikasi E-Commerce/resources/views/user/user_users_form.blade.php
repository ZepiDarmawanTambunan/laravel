@extends('layouts.layout')

@section('title', 'Users')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                {{ $method === 'POST' ? 'Buat' : 'Ubah' }} USER {{ Str::upper($akses) }}
            </h4>
            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group text-center">
                    <img src="{{ $model->image == null ? asset('quixlab-main') . '/theme/images/user/form-user.png' : \Storage::url($model->image) }}"
                        style="height: 150px; width: 150px;" class="img-fluid rounded-circle" alt="image {{ $model->nama }}">
                    <br>
                    {!! Form::file('image', ['class' => 'btn btn-info mt-2']) !!}
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
                <div class="form-group">
                    {!! Form::hidden('akses', $akses, []) !!}
                    <label for="nama">nama <span class="text-danger">*</span></label>
                    {!! Form::text('nama', $model->nama ?? null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>
                <div class="form-group">
                    <label for="email">email <span class="text-danger">*</span></label>
                    {!! Form::email('email', $model->email ?? null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                @if (Request::is($authAkses . '/user/*/edit'))
                    <div class="form-group">
                        <label for="password">password</label>
                        {!! Form::password('password', [
                            'class' => 'form-control',
                            'placeholder' => 'kosongkan jika tidak diubah',
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                @else
                    <div class="form-group">
                        <label for="password">password <span class="text-danger">*</span></label>
                        {!! Form::password('password', ['class' => 'form-control', 'required']) !!}
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                @endif
                <div class="form-group">
                    <label for="no_hp">no hp <span class="text-danger">*</span></label>
                    {!! Form::number('no_hp', $model->no_hp ?? null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                </div>
                @if ($akses != 'admin')
                    <div class="form-group row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="province_id">Provinsi <span class="text-danger">*</span></label>
                            <select name="province_id" class="form-control" required>
                                <option value="">--Provinsi--</option>
                                @foreach ($provinces as $province => $value)
                                    <option value="{{ $province }}"
                                        {{ $province == ($province_id ?? '') ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('province_id') }}</span>
                        </div>

                        <div class="col-md-6">
                            <label for="city_id">Kota <span class="text-danger">*</span></label>
                            <select name="city_id" class="form-control" required>
                                <option value="">--Kota--</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('city_id') }}</span>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    {!! Form::textarea('alamat', $model->alamat ?? null, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>
                @if ($akses == 'admin')
                    <div class="form-group row">
                        <label for="jk" class="col-md-3 col-form-label">{{ __(' Jenis Kelamin') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="jk" id="jk" class="form-control" required>
                                <option value="laki-laki" {{ ($model->admin->jk ?? '') == 'laki-laki' ? 'selected' : '' }}>
                                    Laki
                                    - laki</option>
                                <option value="perempuan" {{ ($model->admin->jk ?? '') == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('jk') }}</span>
                        </div>
                    </div>
                @endif
                @if ($akses == 'pelanggan')
                    <div class="form-group row">
                        <label for="jk" class="col-md-3 col-form-label">{{ __(' Jenis Kelamin') }} <span
                                class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <select name="jk" id="jk" class="form-control" required>
                                <option value="laki-laki"
                                    {{ ($model->pelanggan->jk ?? '') == 'laki-laki' ? 'selected' : '' }}>
                                    Laki - laki</option>
                                <option value="perempuan"
                                    {{ ($model->pelanggan->jk ?? '') == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('jk') }}</span>
                        </div>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary mt-2">{{ $namaTombol }}</button>
                {!! Form::close() !!}
            </div>

            @if ($akses == 'pelanggan' && $method == 'PUT')
                <h2 class="mt-3">RIWAYAT TRANSAKSI</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Penjualan</th>
                                <th>Status Penjualan</th>
                                <th>tanggal transaksi</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $item)
                                <tr>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->status_penjualan }}</td>
                                    <td>{{ $item->total == null ? 'Sedang Dikonfirmasi' : 'Rp. ' . number_format($item->total) }}</td>
                                    <td>{{ $item->created_at->format('d-M-Y') }}</td>
                                    <td>
                                        <a href="{{ url($authAkses . '/penjualan/' . $item->id) }}"
                                            class="btn btn-warning">
                                            <i class="fa fa-info"></i>
                                        </a>
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
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        let cityId = {!! json_encode($city_id ?? '') !!}
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
