@extends('frontend.layout.app')
@section('content')

<!-- SECTION -->
<div class="section" id="billing">
                <!-- container -->
                <div class="container">
                    <!-- row -->
                    <div class="row">
          
                        <div class="col-md-7">
                                <div  class="b-header  main-bg ">
                                        <h3 class="text-shadow" >اكتب العنوان </h3>
                                    </div>
                            <!-- Billing Details -->
                            <div class="billing-details login py-3 box-shadow">
                                <!--  -->
                                @if($errors->any())
                                    <div class="  border border-top-bottom py-3">
                                        <ul class="list-unstyled">
                                            @foreach($errors->all() as $error)
                                                <li class="list-item"><p class="sectionTitle text-right">{{$error}}</p></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!--  -->
                                <!--  -->
                                @if(Session::has('success'))
                                     {{Session::get('success')}}
                                @elseif(Session::has('error'))
                                    {{Session::get('error')}}
                                @endif
                                <!--  -->
                            {!!  Form::open(['url' =>'checkout/order' , 'method' =>'post'])!!}
                                <div class="form-group">
                                    <input class="input" type="text" name="receiverName" placeholder="الاسم ">
                                </div>						
                                <div class="form-group">
                                    <input class="input" type="text" name="receiverPhone" placeholder="التليفون">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="country" placeholder="البلد">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="city" placeholder="المحافظة  ">
                                </div>
                                <div class="form-group">
                                    <input class="input" type="text" name="town" placeholder=" المدينة  ">
                                </div>
                                <div class="form-group">
                                    <textarea name="address" placeholder="  العنوان كاملا"></textarea>
                                </div>
                                                                
                                <div class="form-group text-center">
                                <input type="submit" class="btn  btn-success"  value ="ارسال">
                                </div>
                            {!! Form::Close()!!}
                                <!--  -->
                            </div>
                            <!-- /Billing Details -->
    
                            
                        
                        </div>
                    
                        <!-- order-summary-->
                        <!-- if no data found -->
                        @if(    count($data)  ==  0)
                        <h5 class="SectionTitle">   لا يوجد لديك مشتروات حاليا </h5>
                        @else
                        <!-- if  data found -->
                        <div class="col-md-5 order-details">
                            <div class=" main-bg b-header">
                                <h3 class="text-shadow"> بيانات الطلب </h3>
                            </div>
                            <div class="order-summary px-2 border">
                                <div class="order-col  ">
                                    <div><strong>المنتج</strong></div>
                                    <div><strong>الاجمالى</strong></div>
                                </div>
                                <!--  -->
                                @foreach($data as $key => $row) 
                                    @foreach(App\Cart::where('id' , $row->id)->get() as $item)
                                        <div class="order-products">
                                            <div class="order-col">
                                                <div>  عدد ( {{$item->quantity}}  )
                                                    {{App\Item::getItemName($row->code)}} - 
                                                    <span class="price font-color"> {{$item->color}}</span>  - 
                                                    <span class="price font-color" >{{ $item->size}}</span>
                                                 </div>
                                                <div>
                                                    <span>{{$item->price*$item->quantity}}</span>
                                                    <span class="price font-color">ج</span>
                                                </div>
                                            </div>                                    
                                        </div>
                                    @endforeach
                                @endforeach
                                <!--  -->
                           
                            
                                <div class="order-col">
                                    <div><strong>الاجمالى العام </strong></div>
                                    <div>
                                        <strong class="order-total">{{App\Cart::Total(Auth::User()->id)}}</strong>
                                        <span class="price font-color">ج</span>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- /order-summary -->
                        <!-- if data found -->
                        @endif 
                   
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
        </div>
    <!-- /SECTION -->

    @stop('content')