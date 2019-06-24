
@extends('backend.layouts.app')

@section('content')

<div class="item">
    <div class="container  mt-5 text-center">      
        <div class="row">  
            <div class="col-md-12">
                <!-- admin -->
                <div class="admin ">
                    <div class="formHeader ">
                        <h5 class="sectionTitle"> تعديل سلايدر</h5>
                    </div>
                     <div class="main-bg py-3">
                        <h5 class="title"> بيانات السلايدر</h5>
                   
                    </div> 

               
                      <!--form  -->
                    {!! Form::Open(['class'=>'form-group  box-shadow  text-right' , 'files'=>true]) !!}
                        <h5 class="sectionTitle">
                            @if ($errors->any())
                            <div class="border py-2">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li class="list-item my-2">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                {{Session::get('success')}}
                            @elseif(Session::has('fileErro'))
                                 {{Session::get('fileErro')}}
                            @endif
                        </h5>

                        <div class="full ">
                        <div class="custom-input half">

                                    <div class="full color" style="color:#e2358e">العنوان الرئيسي</div>
                                    <div class="full "> 
                                            <input  class="form-control  " type="text" name="title1" placeholder=" address"  value="{{$slider->title1}} " />
                                    </div>
                                    <div class="full color" style="color:#e2358e">العنوان الفرعي</div>
                                    <div class="full "> 
                                          <input  class="form-control  " type="text" name="title2"  value="  {{$slider->title2}}" />
                                    </div>
                                    <div class="full"><span style="color:#e2358e">المحتوى</span></div>
                                    <div class="full"> 
                                            <textarea name="content"    >{{$slider->content}}</textarea>                                           
                                    </div>
                                    
                                    <div class="full px-5">                                         
                                            <label class="radio-inline half"><input type="radio" name="active" checked value="نعم" @if($slider->active =="نعم") {{'checked'}}  @endif >  مفعل</label>
                                           <label class="radio-inline half"><input type="radio" name="active"  value=" لا"  @if($slider->active =="لا") {{'checked'}}  @endif > غير مفعل</label>
                                  
                                    </div>

                        </div>
                        <!-- half2 -->
                            <div class="custom-input half">
                            <div class="full" style="color:#e2358e">الترتيب</div>
                            <input  class="form-control " type="text" name="sort"   value="{{$slider->sort}}  " />
                           
                                 <div class="full border ">
                                        <input type="file" name="sliderImage" id="sliderImage" title=""   MAX_FILE_SIZE="30000">
                                 </div>

                                    <!-- photo -->

                                        <div style="display:flex; justify-content:space-between;padding:0 10px"><span>الصورة القديمة</span>    <span> الصورة المختارة </span></div>
                                        
                                        <div class="photo   border">
                                        
                                            <img src="{{url($slider->sliderImage)}}" >
                                            <img  id="self_image">

                                        </div>
                                    <!-- photo -->
                                  
                            </div>
                            <!-- half1 -->
                       
                        <!-- md-6 -->

                       
                           
                        </div>
                        <!-- full -->

                 <div class="text-center">          
                     <input   class=" btn get  mb-2 px-3" type="submit" name="addItem" value=" تعديل " />
                 </div>              
             
                        {!! Form::Close() !!}
                        <!-- form -->
                        </div>
                            <!-- admin  -->
       
                </div>
<!-- col-md-12 -->
         </div> <!--row-->
    </div><!--container-->
</div><!--item-->

@endsection
@section('showImagesJs')
<script>

function readURL(input) {

if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function(e) {
    $('#self_image').attr('src', e.target.result);
  }


  reader.readAsDataURL(input.files[0]);
}
}

$("#sliderImage").change(function() {
readURL(this);
});

     
     
</script>


@endsection