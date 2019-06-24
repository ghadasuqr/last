@extends('frontend.layout.app')
@section('content')
@include('frontend.layout.slider')

@include('frontend.products.latest')
@include('frontend.products.mostSoldToIndex')
<!--            sale big ad -->
@if(App\Sale::duration() > 0)
    @include('frontend.layout.sale')
@endif
<!-- sale big ad -->
@endsection