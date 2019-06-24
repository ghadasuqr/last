@extends('backend.layouts.app')
@section('content')

<!-- ================================================================================= -->





<!-- ================================================================================= -->
<div id="sale">
    <div class="container  mt-5 text-right">
        
        <div class="row">  
            <div class="col-md-3"></div>
            <div class="col-md-6 text-center">
                <div class="login ">
                    <div class="formHeader ">
                        <h5 class="sectionTitle"> تعديل تخفيض</h5>
                    </div>
                <div class="main-bg py-3">
                    <h5 class="title">   غير بيانات التخفيض التى تريد </h5>
                    </div>                
                    
                
                    {!! Form::Open(['class'=>'form-group  box-shadow login' ]) !!}
                    <h5 class="infoTitle my-3 text-center">

                        @if(  Session::has('errorStart')  )                    
                            {{   Session::get('errorStart')}}
                        @elseif(Session::has('errorEnd'))
                        {{   Session::get('errorEnd')}}
                        @elseif(Session::has('success'))
                        {{   Session::get('success')}}
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
            
                        <div class="text-right px-2"> <label > تاريخ البداية  الحالى</label>   <span class="font-color mr-5">  {{  App\sale::rightDate($sale->startDate)  }}  </span></div>
                        <input  class="form-control mb-2" type="date" value="05/12/2019" name="startDate"  />
                        <div class="text-right px-2"> <label > تاريخ الانتهاء  الحالى </label>  <span class="font-color mr-5">  {{  App\sale::rightDate($sale->endDate)  }}  </span>  </div>

                        <input  class="form-control mb-2" type="date" name="endDate"  />
                        <div class="text-right px-2"> <label > نسبة الخصم  الحالية </label>  </div>
                        <input  class="form-control mb-2" type="number"   value="{{$sale->percentageValue}}" name="percentageValue"  />
                      
                  
                        <div class="accordion text-right"style="margin:0; max-width:100%">
                             <div class="accordion-header" style="padding:15px "><i class="fa fa-chevron-down"></i>
                                            
                                            <span class=" font-color">   المنتجات     الحالية  فى الخصم      </span>     
                                      </div>
                            <div class="accordion-content">
                                <div class="main-bg "> <span class="Model title pr-2 py-2">  الموديل</span> <span class="Item title   pr-5  py-2"> المنتج</span> </div>
                            @foreach(App\Item::get()  as $key=>$item)

                            <label class="parent_check">

                            
                                    <input type="checkbox"   @if(in_array( $item->code   , $itemsINsale)) checked @endif name="items[]" value=" {{$item->code}} " >
                                    <span  class="Model ">{{App\Imodel::getModeNamelById($item->modelNo)}}   </span>
                                   <span  class="Item "> {{ $item->itemDescription}}  </span>
                                   <!--   Do not Tuoch-->
                                   <span class="checkmark" ></span> 
                                   <!-- Do Not Touch -->
                            </label>
                            @endforeach
                            </div>
                        </div>
                        <input   class=" btn get  my-5" type="submit" name="addSale" value=" تعديل " />
                            
                    {!! Form::Close()!!} 
            
                </div>
                    <!-- login -->
            </div>
            <!-- col-6 -->
            <div class="col-md-3"></div>
        </div> <!--row-->
    </div><!--container-->
</div>
@endsection