@extends('backend.layouts.app')

@section('content')


<div class="page">
    <div class="container">
        <div class="row">

      
             <div class="col-md-12 col-sm-12">


                 <div class="shopping-cart-header main-bg text-center">
                   <h3 class="text-center">      الطلبات الجديدة</h3>
                   <i class="fa fa-star-o fa-2x"></i>
                </div>
           
                <div class="cart">

                    <div class=" container shopping-cart">
                    <!--  befor showing table-->
                      @if(count($data)==0)
                          <div  class="text-right"><h5 class="sectionTitle  " >لا يوجد طلبات   جديدة </h5></div>  
                      @else   
                        <!--  -->                 
                        <div   style ="padding:0" class="shopping-cart-table"> 
                                    <!-- <div class="table-responsive"> -->
                                          <table class="table table-responsive box-shadow  table-bordered  " style="border-top:3px solid pink;">
                                          <tr>
                                              <td colspan="10">
                                                <div class="login">
                                                  {!! Form::Open(['class'=>'form-group  box-shadow login'  , 'method' =>'GET'])!!}
                                                  <input  class="form-control mb-2" type="text" name="q" placeholder="البحث  "  value="@if(isset($_GET['q'])){{$_GET['q']}}@endif"> 
                                                  {!! Form::Close() !!}
                                                </div>
                                              </td>
                                              
                                            </tr>
                                           
                                            <tr>
                                                    
                                                    <td colspan="8" class="text-center">
                                                         <h5 class="sectionTitle">                                                         
                                                         @if(Session::has('success'))                     
                                                            {{   Session::get('success')}}
                                                            @elseif(Session::has('error'))
                                                            {{ Session::get('error')}}
                                                           @endif                                                         
                                                         </h5>
                                                         <h5 class="infoTitle my-3 text-center">
                                                            @if ($errors->any())
                                                                      <div class="border py-2">
                                                                            <ul class="list-unstyled">
                                                                            @foreach ($errors->all() as $error)
                                                                                  <li class="list-item my-2">{{ $error }}</li>
                                                                            @endforeach
                                                                          </ul>
                                                                    </div>
                                                                  @endif
                                                            </h5>
                                                    </td>
                                                    <td>
                                              <h5 class="sectionTitle">  العدد  ({{ count ($data)}})</h5> 
                                              </td>
                                            </tr>
                                            
                                            <tr class="main-bg">
                                                <th class="title"  scope="col" width="200" >مسلسل</th>
                                                <th class="title"  scope="col" width="250">الرقم  </th>
                                                <th  class="title"  scope="col" width="500"> المستخدم </th>
                                                <th class="title"  scope="col" width="100">الحالة   </th> 
                                                <th class="title"  scope="col" width="420">التاريخ </th>                                            
                                                <th class="title"  scope="col" width="200">الموظف     </th>                                             
                                                <th class="title"  scope="col" width="50">  الحالة   </th> 
                                                <th class="title"  scope="col" width="90"> تعديل    </th>                                             
                                                <th class="title"  scope="col" width="90"> تفاصيل  </th>
                                                <th class="title"  scope="col" width="90"> حذف  </th>

                                            </tr>
                                            <tr>
                                            @foreach($data as $key=>$order)
                                            
                                                <td>{{$key+1}}</td>
                                                  <td>{{$order->orderNo}}</td>

                                                    <td >{{App\User::getNameById($order->user_id) }}</td>                                            
                                                    <td>{{App\Order::status($order->status)}}</td>
                                                    <td> {{ App\Sale::rightDate($order->created_at)  }}</td>


                                                    {!! Form::Open(['url' => 'dashboard/orders/new/status/'.$order->orderNo ]) !!}
                                                    <td>
                                                      <select  name="shipperNo" >                      
                                                        
                                                        <option disabled selected value="">اختر موظف</option>
                                                        @foreach(App\User::getSippers() as $key=>$shipper)                                                   
                                                        <option value="{{$shipper->id}}">{{ $shipper->name}}</option>                                                      
                                                        @endforeach
                                                
                                                        </select >
                                                     </td>

                                                    <td>
                                                    <select  name="status" >                      
                                                
                                                    <option disabled selected value="">اختر حالة</option>
                                                    <option value="1">تجهيز</option>
                                                    <option value="2">مكتمل</option>
                                                    </select >
                                                    </td>
                                      
                                                    <td>
                                                    <button class="btn btn-outline-warning"> × تغيير</button>                                                   
                                                    </td>
                                                    {!!  Form::Close()!!}
                                                  


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

                        <!--  if count(data) ==0 -->
                        @endif
                        <!--after showing table  -->
                                         
                    </div>  <!-- container -->

                 </div>    <!--   cart -->
             </div>

                <!--  -->          
        
             <!--  -->
        </div>
        
    </div>
</div>
@endsection