@extends ('backend.layouts.app')
@section('content')
<div class="container ">
<div class="row">
        <div class="shopping-cart-header main-bg">
            <h3>  طلب  &nbsp; &nbsp;{{       App\User::getNameById($userInfo->userId)     }}   </h3>
                <i class="fa fa-shopping-cart fa-2x " ></i>  
        </div>
@if(count($cartIds)==0)
<div  class="text-right"><h5 class="sectionTitle  " >لا يوجد منتجات فى  مشترياتك </h5></div>  
@else
        <div class="shopping-cart-table " style="display:flex;justify-content:center" >        
            <table class="table table-responsive box-shadow " style="padding:40px 120px">
               

                            <tr >
                                <th scope="col">  الرقم  </th>
                                <th scope="col" class="text-right pr-4"> تفاصيل المنتج  </th>
                                <th scope="col">  الموديل  </th> 
                                <th scope="col">  السعر  </th>                            
                                <th scope="col">  الكمية  </th>
                                {{ App\Order::retuneOrder($orderId) }}                                                         
                                                      
                                <th scope="col" width="120">    اجمالى المنتج</th>
                            </tr>
                     
                        
                        <tbody>
                        <!-- data= favorite table  foe certain  authorized user  -->
                            @foreach($cartIds as $key=> $cartId) 
                            <!-- for each code in resulted collection give item info   -->
                            @foreach(App\Cart::where('id' , $cartId)->get() as $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <div  class="item-right">
                                                <div  class="item-img">
                                                    <img  style="width:100px ; height:100px" src="{{url(   App\Itemimage::getImagesForItem($item->code) [0] )  }}" alt="" /> 
                                                </div>
                                                <div class="item-info">     
                                                    <ul >                                                             
                                                            <li> <span class=" titl pl-5 font-color"  >الاسم</span ><span class="info"> {{App\Item::getItemName($item->code)}}  </span></li>
                                                            <li> <span class=" titl pl-5 font-color"  >اللون</span ><span class="info"> {{$item->color}}  </span></li>
                                                            <li> <span class=" titl pl-5 font-color"  >المقاس</span ><span class="info">{{ $item->size}}</span></li>
                                                    </ul>
                                                </div>
                                        </div>
                                    </td>
                                   
                                    <td class="text-right"> 
                                          <p class=" font-color ">الموديل</p>
                                        <span class="py-5 ">{{App\Imodel::getModeNamelById($item->modelNo)}}</span>
                                    </td>

                                    <td> 
                                        <div class="price-wrap"> 
                                            <var class="price"> {{$item->price}} </var> <span class="price font-color">ج</span>
                                        </div> <!-- price-wrap .// -->
                                    </td>
                                    <td> ( {{$item->quantity}} )  </td>
                                    <!-- if is returned to returned page only -->
                                        @if($item->isReturned ==1)
                                        <td  style="background:#ebbad6"> {{App\Order::isReturned($item->isReturned)  }}</td>
                                        @endif
                                    <!-- if is returned to returned page only -->
                             
                                    <td class="text-right"> 
                                            <span>{{$item->price*$item->quantity}}</span><span class="price font-color">ج</span>
                                    </td>
                                    
                                    
                                </tr>
                                @endforeach
                            <!-- end item info -->
                            @endforeach
                            <!--  end collection for certain user  -->
                            <tr class="border-top">
                                <td colspan="3"></td>
                                @if($item->isReturned ==1)    
                                <td  colspan="2" >  المدفوع بعد الارجاع  </td>
                                @endif

                                @if($item->isReturned ==0)    
                                <td colspan="2"> الاجمالى الكلى   </td>
                                @endif

                                <td  colspan="2" class="text-right  box-shadow  border-top-bottom px-3" >{{App\Cart::  TotalForOrder($cartIds)  }} <span class="price  font-color">ج</span></td>
                            </tr>
                           
                        </tbody>
                        @endif
            </table>
            </div>        
        </div>

    </div>  <!--  row-->
    
</div> <!-- container --> 



<div class="all_items">
    <div class="container">
        <div class="row">            
            <div class="col-md-12 col-sm-12">
                
            
            
                                <table class="table  table-responsive   box-shadow  px-5  ">
                     
                                    <tbody style="width:100%">
                                    <tr ><td colspan="3">  <h3 class="sectionTitle">  بيانات مستلم الطلب  </h3></td></tr>
                                            <tr>
                                            <td>
                                                <div class="basic_detail">
                                                    <div>
                                                            <span class="mb-2" > اسم المستلم </span>
                                                            <h5> {{$userInfo->receverName}}</h5>
                                                        </div>
                                                        <div>
                                                            <span>  تليفون المستلم </span> 
                                                            <h5>{{$userInfo->receverPhone}}</h5>
                                                         </div>
                                                </div>
                                                <!-- basic_detail -->
                                            </td>
                                            <!-- design Details -->
                                           
                                            <td>
                                                <div class="basic_detail">
                                                    <div>
                                                            <span> البلد  </span>
                                                            <h5> {{$userInfo->country}}</h5>
                                                        </div>
                                                        <div>
                                                            <span>  المحافظة  </span> 
                                                            <h5>{{$userInfo->city}}</h5>
                                                         </div>
                                                        
                                                </div>
                                                <!-- basic_detail -->
                                            </td>
                                            <td>
                                                <div class="design_detail_bigger">
                                                        <div>
                                                            <span class="font-color">  المدينة  </span> 
                                                            <h5 class="border py-2 px-2">{{$userInfo->town}}</h5>
                                                         </div>
                                                        <div class="advice-content "> 
                                                        <span>  العنوان </span>                                            
                                                        <div class="contents"> {{$userInfo->address}}  </div>
                                                        </div>
                                                </div>
                                                <!-- basic info -->
                                            </td>
                                            <!--  end design details -->
                                            </tr>
               
                                    </tbody>
                                </table>
      
            </div>
        <!-- col-md-12 -->
            
        </div>
        <!-- row -->
    </div>
        <!-- container main one -->
</div>
<!-- all_items -->

@endsection();