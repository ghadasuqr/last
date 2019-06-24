@include ("frontend.layout.header")
<script type="text/javascript" src="{{url('frontend/assets/js/jquery-3.3.1.min.js')}}"></script>

<script type="text/javascript" src="{{url('frontend/assets/js/listGrid.js')}}"></script>

<div class="container">

    <div class="row">
            <div class="buttons ">
                    <button class="btn active" tooltop="grid" id="grid">شبكة<i  class="fa fa-th"></i></button>
                    <button   class="btn" id="list" > قائمة<i class="fa fa-list"></i></button>
            </div>
    </div>

</div>
<!-- list grid buttons// must be separate -->
<div class="container products">
    <div class="row text-right">
@include ("frontend.layout.sidebar")
        <!-- Error if found -->
       
    
        <!-- Error if found -->
        <!--content  -->
        <div class="gridview  col-sm-9 col-md-9">
        <!-- Error if found -->
            @if(count($items)== 0)
              <h5 class="sectionTitle border py-3">
              
                    لا توجد ملابس بهذه المواصفات
            </h5>
            @endif
            <!-- Error if found -->
                 <div   class="row  mb-5"> <!-- row-->
                 @foreach($items as $item)
                    <div class="col-md-4  col-sm-6 mb-5">
                    <div class="product-grid box-shadow ">
                        <div class="product-image">
                            <a href="{{url('products/details/'.$item->code)}}">
                            <?php $images=array();
                            $images=App\Itemimage::getImagesForItem($item->code);                                   
                            ?>
                                <img class="pic-1 " src="{{url($images[0])}}">                         
                                <img class="pic-2" src="{{url( $images[1])}}">
                            </a>
                            <ul class="social">
                                <li><a href="{{url('products/details/'.$item->code)}}" data-tip="تفاصيل"><i class="fa fa-search"></i></a></li>
                                <!--  -->
                                <li>
                                    <a  href=" @if (! Auth::check()) {{ url('login')}} @endif"
                                     class="@if ( !App\Favorite:: inWishList($item->code)) AddToWishlist @endif" 
                                        data-id= "{{$item->code}}"  
                                         data-tip="@if ( App\Favorite:: inWishList($item->code))  مضافة من قبل  @else   اضف للمفضلة  @endif ">
                                        <i class="@if ( App\Favorite:: inWishList($item->code))  fa fa-check @else  fa fa-heart @endif"  id="wish_{{$item->code}}"></i>
                                    </a>
                                </li>
                                <!--  -->
                               
                                <li><a href="{{url('products/details/'.$item->code)}}" data-tip="اضف لمشترياتك"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                            @if(App\Sale::isCurrent($item->code))
                            <?php $discount=App\Sale::isCurrent($item->code); ?>
                            <span class="product-new-label">sale</span>
                            <span class="product-discount-label">{{ $discount }}</span>
                            @endif                                  

                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="{{url('products/details/'.$item->code)}}"> {{$item->itemDescription}} </a></h3>
                            <div class="price">
                            @if(App\Sale::isCurrent($item->code))
                               
                                    <span class="newPrice">  {{  $item->price - ($item->price * $discount) / 100   }}  </span><span >ج</span> 
                                @endif  
                                    <span  class="{{ (App\Sale::isCurrent($item->code) ? 'oldPrice' : 'newPrice') }}" >
                                        {{$item->price}} ج  </span>
                                </div>
                                <a href=""><button  class="buy">تفاصيل</button></a>
                        </div>
                </div>
            
                    </div>
                    <!-- col-sm-6 -->
                  @endforeach
                   
                 </div> <!--row-->
                 <!--  -->

        </div>
        <!-- gridview -->

        <!-- content   grid -->

        <!-- content  list -->
        <!-- ================================================================================ -->

        <div class="col-md-9">

            <div class="Listview ">
                <!-- Error if found -->
                @if(count($items)== 0)
              <h5 class="sectionTitle border py-3">
                    لا توجد ملابس بهذه المواصفات 
                </h5>
            @endif
                    <div class="row ">
          
            <!-- Error if found -->
                        <!-- item -->
                        @foreach($items as $item)

                            <div class=" col-sm-12">
                                <div class="_product-grid border">
                                    <div class="_product-image">
                                         <!-- image --> 
                                                <?php $images=array();
                                                      $images=App\Itemimage::getImagesForItem($item->code);                                   
                                                ?>                         
                                            <img class="_pic-1 " src="{{url($images[0])}}"> 
                                                 <!--  -->
                                                                         <!--  -->
                                            
                                          @if(App\Sale::isCurrent($item->code))
                                        <span class="_product-discount-label">sale</span>
                                        @endif
                                    </div>
                                    <!-- image -->
                                     <!-- content -->
                                    <div class="_product-content  ">
                                        
                                           @if(App\Sale::isCurrent($item->code))
                                            <?php $discount=App\Sale::isCurrent($item->code); ?>      
                                            <span class="_product-new-label"> {{ $discount}} %</span>
                                            @endif

                                            <!--  -->
                       
                                            <!--  -->
                                            <div class="_price">
                                                    <h3> 

                                                        <span class="desc">السعر : </span>
                                                        @if(App\Sale::isCurrent($item->code))                               

                                                          <span class="_newPrice">{{  $item->price - ($item->price * $discount) / 100   }}  </span> <span>ج</span> 
                                                        @endif  
                                                        <span  class="{{ (App\Sale::isCurrent($item->code) ? '_oldPrice' : '_newPrice') }}" >
 
                                                        {{$item->price}}
                                                       ج
                                                        </span> 
                                                    </h3>                 
                                            </div>
                                        <h3 > <span class="model">الموديل : </span> {{App\Imodel::getModeNamelById($item->modelNo)}} </h3>
                                        <h3 ><span class="desc"> الوصف: </span>  {{$item->itemDescription}}  </h3>
                             

                                                <div >
                                                        <ul  class="list-list">
                                   
                                                   
                                                            <li> 
                                                                    <a href="{{url('products/details/'.$item->code)}}" alt="add to favorite">
                                                                        <button class="get"> تفاصيل 
                                                                              <i class="fa fa-search "></i>                                                           
                                                                         </button>
                                                                    </a>
                                                                </li>

                                                        </ul>
                                                </div>
                                    </div>                                        
                                     <!--content  -->
                                </div>
                                <!-- grid -->
                            </div>
                            <!--  col-12  -->
                        <!-- item -->
                     @endforeach

<!--       ================================================                      -->
                    </div> <!-- row listview-->
        
             </div> <!-- List view-->
        </div> <!-- col-md-9 listview-->

        <!-- content List -->
    </div>
    <!-- row -->
</div>
<!-- container -->
@include ("frontend.layout.footer")
</body>
</html>