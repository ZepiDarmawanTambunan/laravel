@extends('layouts.layout')

@section('title', 'Produk')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2 mb-5">
        <div class="card-body">
            <h4 class="card-title mb-4">
                {{ $method === 'POST' ? 'Buat' : 'Ubah' }} Produk
            </h4>

            <div class="basic-form">
                {!! Form::model($model, ['url' => $url, 'method' => $method, 'files' => true]) !!}
                <div class="form-group">
                    <label for="image">Gambar produk</label>
                    <br>
                    @if ($method == 'PUT')
                        <img src="{{ $model->image == null ? asset('quixlab-main') . '/theme/images/default/terpal_(2).jpg' : \Storage::url($model->image) }}"
                            style="height: 150px; width: 150px;" class="img-thumbnail" alt="image {{ $model->name }}">
                        <br>
                    @endif
                    {!! Form::file('image', ['class' => 'btn btn-info mt-2']) !!}
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
                
                @if($method == 'POST')
                <div class="form-group">
                    <label for="kode_barang">Kode barang <span class="text-danger">*</span></label>
                    <input type="text" name="kode_barang" value="{{$id??null}}" class="form-control" readonly required>
                    <span class="text-danger">{{ $errors->first('kode_barang') }}</span>
                </div>
                @endif

                <div class="form-group">
                    <label for="nama">nama barang <span class="text-danger">*</span></label>
                    {!! Form::text('nama', $model->nama ?? null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>

                <div class="form-group">
                    <label for="harga">Harga <span class="text-danger">*</span></label>
                    <input type="text" name="harga" id="harga" class="form-control" required
                        value="Rp. {{ number_format($model->harga??null) }}">
                    <span class="text-danger">{{ $errors->first('harga') }}</span>
                </div>

                <div class="form-group">
                    <label for="berat">berat (gram) <span class="text-danger">*</span></label>
                    {!! Form::number('berat', $model->berat ?? null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('berat') }}</span>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                    {!! Form::number('jumlah', $model->jumlah ?? null, ['class' => 'form-control', 'required']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                    {!! Form::textarea('deskripsi', $model->deskripsi ?? null, ['class' => 'form-control', 'rows' => 3, 'required']) !!}
                    <span class="text-helper">{{ $errors->first('deskripsi') }}</span>
                </div>
                <button type="submit" class="btn btn-primary mt-2">{{ $namaTombol }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        const el = document.getElementById('harga');

        el.addEventListener('input', handle);

        function handle(e) {
            el.value = formatRupiah(e.target.value, "Rp. ");
        }
    </script>
@endsection
