@extends('errors::illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('image')
    <div style="background-image: url('/quixlab-main/theme/images/default.jpg'); background-size:cover;"
        class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection
@section('message', __('Server Error'))
