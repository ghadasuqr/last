@extends('backend.layouts.app')
@section('content')
<div class="container" >
        <div class="row">
                    
             <div class="col-md-12 col-sm-12">
                 <div class="shopping-cart-header main-bg text-center">
                 <i class="fa fa-dashboard fa-3x" style="color:#fff"></i>

                   <h3 >      أهلا {{Auth::user()->name  }} </h3>                         
                </div>
                </div>
                <!-- col12 -->
        </div>
        <!-- row -->
</div>
<!-- container -->
@include('backend.layouts.mostSoldAdmin')
@include('backend.layouts.mostRatedAdmin')

@endsection