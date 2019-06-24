@extends('frontend.layout.app')
@section('content')

<!--=========================================================================================================-->
	
<div class="container  my-5">
<div class="row">
        <!-- show message after send order -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^  hide  invoice in error message   -->

                <div><h5 class="sectionTitle text-center">
                @if(Session::has('successO'))
                {{Session::get('successO') }}
                   @endif

                 </h5>  </div>
              
            
 <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^  hide  invoice in error message  -->






<div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row ">
                        <div class="col-md-6">
                            <h5 class="sectionTitle  text-right px-5" > شركة مسك  لملابس المحجبات</h5>
                     
                        </div>

                        <div class="col-md-6 text-center px-5 pt-3">
                            <p class="font-weight-bold mb-1">فاتورة رقم   #{{ $id }}</p>
                            <p class="font-color ml-3">بتاريخ : {{ Date('Y-m-d') }}</p>
                        </div>
                    </div>

                    <hr class="my-2 color-font">
<!-- ================================================================== -->
                    <div class="row   p-3">
                        <div class="col-md-6 text-right px-5">
                            <p class="font-weight-bold mb-4"> <span class=" border-bottom py-3"> تفاصيل   الشحن  </span> </p>
                            <p class="mb-1"> <span class="font-color ml-3"> الاســـم :</span> {{App\Order::userInfo($id)->receiverName}}</p>
                            <p class="mb-1"><span class="font-color  ml-3"> التليفون :</span>{{App\Order::userInfo($id)->receiverPhone}}</p>
                            <p class="mb-1"><span class="font-color ml-3"> البلــــد :</span>{{App\Order::userInfo($id)->country}}</p>
                            <p class="mb-1"><span class="font-color ml-3"> المحافظة :</span>{{App\Order::userInfo($id)->city}}</p>
                            <p class="mb-1"><span class="font-color ml-3"> المديــنة :</span> {{App\Order::userInfo($id)->town}}</p>
                            <p class="mb-1"><span class="font-color ml-3"> العنوان :</span>{{App\Order::userInfo($id)->address}}</p>
                            
                        </div>

                        <div class="col-md-6  px-5 text-center px-5 ">
                            <p class="font-weight-bold mb-4 "> <span class=" border-bottom py-3"> تفاصيل  الفاتورة </span> </p>
                            <p class="mb-1"><span class="font-color ml-3 ">طريقة الدفع  : </span> كاش</p>
                            <p class="mb-1"><span class="font-color mi-3">اسم العميل : </span> غادة صقر  </p>
                        </div>
                    </div>
<!-- ============================================================================================================================================ -->
<!-- ======================================================================================================================================================= -->
                   <div class="row px-5 pt-2">
                        <div class="col-md-12">
                            <table class="table">
                                <thead class="border-top-bottom">
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">الرقم</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">الموديل</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">الاسم</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">الكمية</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">اللون </th>
                                        <th class="border-0 text-uppercase small font-weight-bold">المقاس</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">السعر    </th>                                  
                                          <th class="border-0 text-uppercase small font-weight-bold">التخفيض للوحدة  </th>
                                          <th class="border-0 text-uppercase small font-weight-bold">  السعر بعد التخفيض  </th>
                             
                                        <th class="border-0 text-uppercase small font-weight-bold">الاجمالى </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Order::cartIds($id) as $key=> $cartId  )
                                   
                                    <!--  -->
                                    <?php $count = count(App\Order::cartIds($id)) ;?>

                                    <!--  -->
                                        @foreach(App\Cart::where('id' , $cartId)->get() as $item)
                                        <!--  -->
                                            @if(App\Sale::isCurrent($item->code))
                                                  <?php $discount=App\Sale::isCurrent($item->code); 
                                                  $discountPrice =  $item->price - ($item->price * $discount) / 100 ;
                                                  ?>
                                            @endif
                                        <!--  -->

                                            <tr>
                                              <td>{{ $item->code}}</td>
                                                <td>{{ App\Imodel::getModeNamelById($item->modelNo)  }}</td>
                                                <td>  {{  App\Item::getItemName($item->code) }} </td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->color }}</td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->price }} ج </td>   <!--  price before discount  -->
                                                <!-- discount -->
                                                @if(App\Sale::isCurrent($item->code))
                                               <td>  {{ $discount }}</td>
                                        
                                                  @else
                                                  <td> ------ </td>
                                                  @endif
                                                  <!-- discount -->
                                                  <!--  price-->
                                                  @if(App\Sale::isCurrent($item->code))                                           
                                                      <td> {{  $discountPrice   }} </td>
                                                    @else
                                                      <td>{{ $item->price }} </td>
                                                    @endif
                                                    <!-- price -->
                                                         <!--  itemTotal-->
                                                         @if(App\Sale::isCurrent($item->code))
                                                         <td id="itemTotal{{$key}}">{{ $item->quantity * $discountPrice }} </td>

                                                      @else
                                                      <td id="itemTotal{{$key}}">{{ $item->quantity * $item->price }} </td>

                                                      @endif
                                             

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
<!-- ===================================================================================== -->
                    <div class="d-flex flex-row-reverse bg-dark text-white p-2 ">
                        <div class="py-3 px-5 text-right">
                            <!-- <div class="mb-2">Grand Total</div> -->
                            <div class="h2 font-weight-light">   <span > الاجمالى   </span>
                            <span id="overAllTotal"></span>
                        
                            
                            <span> ج</span></div>
                        </div>

                    </div>
                </div>         <!-- card body-->
         
            </div>   <!-- card -->  

        </div>      <!-- col-12 -->    

<!-- ------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------------------------------------------------- -->
<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^  hide  invoice in error message  -->

<!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^  hide  invoice in error message  -->

</div>          <!-- row -->

</div>     <!-- container -->   
<!-- javascript ti calculate  overall  total -->
@endsection
@section('totalInvoiceJS')
<script>

$(document).ready(function (){
    var overAllTotal=0;
    var countitems=$('#countItems').text();
    
    var count = <?php echo json_encode($count); ?>;
    //  var count= parseInt($('#countItems').text() );


    var i;
    for(i=0 ; i<count ;i++){

        overAllTotal=overAllTotal + parseInt($('#itemTotal'+i).text()); 
    }

// alert(overAllTotal);
$('#overAllTotal').text(overAllTotal);

});
</script>

@endsection