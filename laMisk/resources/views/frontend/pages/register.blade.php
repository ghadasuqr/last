@extends('frontend.layout.app')
@section('content')
<div class="container  mt-5 text-right">
      
      <div class="row">  
          <div class="col-md-3"></div>
          <div class="col-md-6 text-center">
              <div class="login ">
                  <div class="formHeader ">
                      <h5 class="sectionTitle"> التسجيل</h5>
                  </div>
              <div class="main-bg py-3">
                  <h5 class="title">من فضلك  اكتب بياناتك</h5>
                  </div>
                          
                  
              
                  {!! Form::Open(['class' =>'form-group  box-shadow login']) !!} 
                
                    <!-- displaye errors -->
                    @if(Session::has('emptErrors') )
                    
                            <div class="border py-3">
                                <ul class="list-unstyled">
                                    @foreach(Session::pull('emptErrors') as $emptError)
                                        <h5 class="infoTitle my-3 "> 
                                        <li class="list-item my-3"> {{$emptError}}</li>
                                        </h5>
                                    @endforeach
                                </ul> 
                             </div>
                             @endif
                    @if(Session::has('success'))
                            <h5 class="infoTitle my-3 "></h5> 
                                {{Session::get('success')}}
                    @elseif(Session::has('error'))
                            <h5>  {{Session::get('error')}} </h5> 
                    @endif
         
                 
               
                 
  
                      <input  class="form-control my-2" type="text" name="name"   placeholder="الاسم" />
                          
                      <input  class="form-control mb-2" type="text" name="mail"  placeholder="البريد الالكترونى " />
                      <input   class="form-control mb-2" type="password" name="password"   placeholder="كلمة السر " />
  
                      <input    class="form-control  mb-2" type="password" name="confirmpassword"   placeholder="تأكيد كلمة السر " />           
                      <!-- ============================================ ====================================-->
                      <div>
                           <label class="radio-inline"><input type="radio" value="أنثى" name="gender">أنثى</label>
                          <label class="radio-inline"><input type="radio" value="ذكر" name="gender">  ذكـر</label>
                      </div>
  <!-- ============================================================================================= -->
                      <input   class=" btn get  mb-2" type="submit" name="register" value=" تسجيل " />
                           
                  {!! Form::Close()!!}
                  <div class="py-3">
                          <strong> هل انت مسجل مسبقا </strong> 
                          <a   href="{{url('login')}}" > دخول من هنا </a>
                  </div>
              </div>
                  <!-- login -->
          </div>
          <!-- col-6 -->
          <div class="col-md-3"></div>
       </div> <!--row-->
  </div><!--container-->
@endsection
