@extends('adminlte::page')

@section('content')
    <h1 class="text-center">{{ __('locale.list_tariffs') }}</h1>
    <tariff-pages></tariff-pages>
@endsection
