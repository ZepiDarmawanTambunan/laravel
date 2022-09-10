@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('image')
    <div style="background-image: url('/quixlab-main/theme/images/default.jpg'); background-size:cover;"
        class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection
@section('message', __('Not Found'))
