@extends('backend.layouts.appShipper')
@section('content')
<div class="page">
    <div class="container">
        <div class="row">
            
             <div class="col-md-12 col-sm-12">
                 <div class="shopping-cart-header main-bg text-center">
                   <h3 class="text-center">      طلباتك <span class="mr-3">  {{ Auth::User()->name}} </span></h3>
                   <i class="fa fa-star-o fa-2x"></i>
                </div>
           
                <div class="cart">

                    <div class=" container shopping-cart">                            
<!--  befor showing table-->
@if(count($data)==0)
  <div  class="text-right"><h5 class="sectionTitle  " >لا يوجد طلبات   للارجاع </h5></div>  
@else   
<!--  -->                                                  
                        <div class="shopping-cart-table"> 
                                    <!-- <div class="table-responsive"> -->
                                          <table class="table table-responsive box-shadow  table-bordered px-5  " style="border-top:3px solid pink;">
                                          <tr>
                                              <td colspan="5">
                                                <div class="login">
                                                  {!! Form::Open(['class'=>'form-group  box-shadow login'  , 'method' =>'GET'])!!}
                                                  <input  class="form-control mb-2" type="text" name="q" placeholder="البحث  "  value="@if(isset($_GET['q'])){{$_GET['q']}}@endif"> 
                                                  {!! Form::Close() !!}
                                                </div>
                                              </td>
                                              
                                            </tr>
                                           
                                            <tr>
                                                    
                                                    <td colspan="4" class="text-center">
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
                                                <th class="title"  scope="col" width="250">رقم الطلب </th>
                                                <th class="title"  scope="col" width="300">اسم المستخدم </th>                                             
                                                <th class="title"  scope="col" width="300">التاريخ  </th>                                          
                                                <th class="title"  scope="col" width="100"> تفاصيل  </th>

                                            </tr>
                                            <tr>
                                            @foreach($data as $key=>$order)
                                            
                                                <td>{{$key+1}}</td>
                                                  <td>{{$order->orderNo}}</td>

                                                    <td>{{App\User::getNameById($order->user_id) }}</td>
                                                
                                                    <td> {{ App\Sale::rightDate($order->created_at)  }}                                                    </td>


                                                    <td class="text-right"> 
                                                    <a href="{{url('dashboard/orders/detailToShipper/'.$order->orderNo)}}" class="btn btn-outline-warning px-1"><i class="fa fa-eye"></i> تفاصيل</a>
                                                    </td>
                                       
                                                    
                                            </tr>
                                       
                                            @endforeach                                        
                                        </table>
                                    <!-- </div>        -->
                            
                        </div> 
                        <!--shopping cart table  -->
<!--  if count(data) ==0 -->
@endif
<!--after showing table  -->                       
                                         
                    </div>  <!-- container -->

                 </div>    <!--   cart -->
             </div>
        </div>
        
    </div>
</div>
@endsection