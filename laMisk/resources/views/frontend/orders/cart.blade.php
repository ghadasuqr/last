@extends('frontend.layout.app');
@section('content')

<!--=========================================================================================================-->
	
<div class="container ">
<div class="row">
        <div class="shopping-cart-header main-bg">
            <h3> مشترياتك&nbsp; &nbsp;{{ Auth::User()->name}}   </h3>
                <i class="fa fa-shopping-cart fa-2x " ></i>  
        </div>
        <!-- show message after send order -->

        <div>
                <h5 class="sectionTitle">
                @if(Session::has('successO'))
                            {{Session::get('successO')}}
            @elseif( Session::has('errorO') )
                                {{Session::get('errorO')}}
                                @endif  
                </h5>
                                        
             </div>
        <!-- show message after send order -->

@if(count($data)==0)
<div  class="text-right"><h5 class="sectionTitle  " >لا يوجد منتجات فى  مشترياتك </h5></div>  
@else
        <div class="shopping-cart-table " style="display:flex;justify-content:center" >        
            <table class="table table-responsive box-shadow " style="padding:40px 120px">
                <!--  messages -->
           
                    <tr style="width:100%">
                        <td colspan="6" class="text-center ">
                            <div>
                                    <h5 class="sectionTitle">
                                    @if(Session::has('success'))
                                                {{Session::get('success')}}
                                @elseif( Session::has('error') )
                                                    {{Session::get('error')}}
                                                    @endif  
                                    </h5>
                                                         
                            </div>
                        </td>  
                        <td><h5 class="sectionTitle">العدد ( {{ count ($data)}})</h5> </td>                  
                    </tr>
                
                    <!--  messages -->

                            <tr >
                                <th scope="col">  الرقم  </th>
                                <th scope="col" class="text-right pr-4"> تفاصيل المنتج  </th>
                                <th scope="col">  الموديل  </th> 
                                <th scope="col">  السعر  </th>                            
                                <th scope="col">  الكمية  </th>                            
                                <th scope="col" width="120"> اجمالى  </th>
                                <th scope="col" class="text-center" width="200">حـذف</th>
                            </tr>
                     
                        
                        <tbody>
                        <!-- data= favorite table  foe certain  authorized user  -->
                            @foreach($data as $key => $row) 
                            <!-- for each code in resulted collection give item info   -->
                                @foreach(App\Cart::where('id' , $row->id)->get() as $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <div  class="item-right">
                                                <div  class="item-img">
                                                    <img  style="width:100px ; height:100px" src="{{ url( App\Itemimage::getImagesForItem($item->code)[0] )  }}" alt="" />
                                                </div>
                                                <div class="item-info">     
                                                    <ul >                                                             
                                                            <li> <span class=" titl pl-5 font-color"  >الاسم</span ><span class="info"> {{App\Item::getItemName($row->code)}}  </span></li>
                                                            <li> <span class=" titl pl-5 font-color"  >اللون</span ><span class="info"> {{$item->color}}  </span></li>
                                                            <li> <span class=" titl pl-5 font-color"  >المقاس</span ><span class="info">{{ $item->size}}</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                    </td>
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
                                    <td> 
                                        <select class="cartQtySelect" data-id="{{ $item->code}}">
                                        <?php $quantity =array(1 , 2, 3, 4 , 5, 6, 7, 8, 9, 10) ;?>
                                        @foreach($quantity as $key=>$value)
                                        <option value="{{$value}}" @if ($value == $item->quantity) selected @endif   > {{ $value}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td class="text-right"> 
                                            <span id ="totalOfItem_{{$item->code}}">{{$item->price*$item->quantity}}</span><span class="price font-color">ج</span>
                                    </td>
                                    <td class="text-center"> 
                                        <a href="{{url('cart/'.$item->id)}}" class="btn get px-3" style="margin-top:0"> × حذف</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            <!-- end item info -->
                            @endforeach
                            <!--  end collection for certain user  -->
                            <tr class="border-top">
                                <td colspan="4"></td>
                                <td class=""> الاجمالى الكلى </td>
                                <td  colspan="2" class="text-right  box-shadow  border-top-bottom px-3"  id="totalOfCart" >{{App\Cart::Total(Auth::User()->id)}} <span class="price  font-color">ج</span></td>
                            </tr>
                            <tr><td colspan="7" class="text-center">

                                <a href="{{url('checkout/create')}}" class="btn get px-5">طلب </a></td>

                             </tr>                            
                        </tbody>
        
            </table>
         </div> 
@endif
        <!-- </div> -->

    </div>  <!--  row-->
    
</div> <!-- container --> 

 <!--==========================================================================================================================-->
 @endsection
 <!-- javascript AJAX -->
 @section('cartJS')
 <script>

$( document ).ready(function() {
 

    $('.cartQtySelect').change(function(){
    
        var  code= $(this).attr('data-id');
        var quantity=$(this).val();
        $("#totalOfItem_"+code).text('تعديل...');
            $("#totalOfCart").text('تعديل...');



    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    // // URL ==  "{{ url('')}}"  route  in thye web file of the funcction in  product control  

    var URL="{{url('ajax/updateCart')}}";
        $.ajax({
            url: URL ,
            method:'POST' ,
            data:{code:code , quantity:quantity} ,
            datatype:'json',
            success:function(data){
                if(data.success){
                    $("#totalOfItem_"+code).text(data.subtotal) ;
                    $("#totalOfCart").text(data.total) ;
                    responce.log(data.total);
         
                }else{

              
                }
            }//success
        });//ajax
    });//change
});//ready

</script>
 @endSection
 <!-- javascript AJAX -->

