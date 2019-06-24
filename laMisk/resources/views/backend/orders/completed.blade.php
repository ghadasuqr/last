@extends('backend.layouts.app')

@section('content')

<!--  -->
<div class="page">
    <div class="container">
        <div class="row">
            
             <div class="col-md-12 col-sm-12">
                 <div class="shopping-cart-header main-bg text-center">
                   <h3 class="text-center">    الطلبات  المكتملة  </h3>
                   <i class="fa fa-star-o fa-2x"></i>
                </div>
           
                <div class="cart">

                    <div class=" container shopping-cart">                            
                                                 
                        <div class="shopping-cart-table"> 
                                    <!-- <div class="table-responsive"> -->
                                          <table class="table table-responsive box-shadow  table-bordered px-5  " style="border-top:3px solid pink;">
                                          <tr>
                                              <td colspan="8">
                                                <div class="login">
                                                  {!! Form::Open(['class'=>'form-group  box-shadow login'  , 'method' =>'GET'])!!}
                                                  <input  class="form-control mb-2" type="text" name="q" placeholder="البحث  "  value="@if(isset($_GET['q'])){{$_GET['q']}}@endif"> 
                                                  {!! Form::Close() !!}
                                                </div>
                                              </td>
                                              
                                            </tr>
                                           
                                            <tr>
                                                    
                                                    <td colspan="7" class="text-center">
                                                         <h5 class="sectionTitle">                                                         
                                                         @if(Session::has('success'))                     
                                                            {{   Session::get('success')}}
                                                            @else
                                                            {{ Session::get('error')}}
                                                           @endif                                                         
                                                         </h5>
                                                    </td>
                                                    <td>
                                              <h5 class="sectionTitle">  العدد  ({{ count ($data)}})</h5> 
                                              </td>
                                            </tr>
                                            
                                            <tr class="main-bg">
                                                <th class="title"  scope="col" width="200" >مسلسل</th>
                                                <th class="title"  scope="col" width="250">رقم  </th>
                                                <th class="title"  scope="col" width="500">اسم المستخدم </th>
                                                <th class="title"  scope="col" width="300">التاريخ </th>
                                                <th class="title"  scope="col" width="150">الحالة  </th>
                                                <th class="title"  scope="col" width="100">ارجاع </th>
                                                <th class="title"  scope="col" width="100"> تفاصيل  </th>
                                                <th class="title"  scope="col" width="100"> حذف  </th>

                                            </tr>
                                            <tr>
                                            @foreach($data as $key=>$order)
                                            
                                                <td>{{$key+1}}</td>
                                                  <td>{{$order->orderNo}}</td>

                                                    <td >{{App\User::getShipperById($order->user_id) }}</td>
                                                    <td> {{ App\Sale::rightDate($order->created_at)  }}                                                    </td>
                                                    <td>{{App\Order::status($order->status)}}</td>
                                                    <td>{{App\Order::isReturned($order->isReturned)}}</td>


                                                    <td class="text-right"> 
                                                    <a href="{{url('dashboard/orders/detail/'.$order->orderNo)}}" class="btn btn-outline-warning px-1"><i class="fa fa-eye"></i> تفاصيل</a>
                                                    </td>
                                                    {!! Form::Open(['url' => 'dashboard/orders/delete/'.$order->orderNo ]) !!}

                                                    <td class="text-right"> 

                                                    <button class="btn btn-outline-danger"> × حذف</button>
                                                    </td>
                                                    {!! Form::Close()!!}
                                                    
                                            </tr>
                                       
                                            @endforeach                                        
                                        </table>
                                    <!-- </div>        -->
                            
                        </div> 
                        <!--shopping cart table  -->
                                         
                    </div>  <!-- container -->

                 </div>    <!--   cart -->
             </div>
        </div>
        
    </div>
</div>
@endsection