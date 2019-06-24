<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Slider;
use Session;
use Exception;
use Redirect;
use DB;
use Image;
use File;

class SlideCtrl extends Controller
{

    public function index()

    {
        if(isset($_GET['q'])){
            $q=$_GET['q'];
            $slider=Slider::where('title1' , 'LIKE' , '%'.$q.'%')
                            ->orwhere('title2' , 'LIKE' , '%'.$q.'%')
                            ->orwhere('content' , 'LIKE' , '%'.$q.'%')->get();
        }else{
        $slider=Slider::all();        
        }
        return view('backend.slides.list')->withslider($slider);
    }

#End Index-------------------------------------------------------#
#--------------------------------------------------------------------------#
    public function create()
    {
        return view('backend.slides.create');
    
    }
#End create-------------------------------------------------------#
#--------------------------------------------------------------------------#

    public function store(Request $request)
    {
        $request->validate(['title1' =>'regex:/^[ءa-zA-Zأ-ي\s]*$/u|required|min:6|max:15',
                            'title2' =>'regex:/^[ءa-zA-Zأ-ي\s]*$/u|required|min:10|max:30',
                            'content' =>'regex:/^[ء-zA-Zأ-ي\s]*$/u|required|min:10|max:50',
                             'sort'=>'integer|min:0|max:10',
                             'sliderImage'=>'required|max:10000'
        ]);

        try{
            
        $file = $request->file('sliderImage');
        $allowedExtensions=['png' , 'jpg' ,'PNG','jpeg'];

        $ext=$file->getClientOriginalExtension();
        $fileName=$file->getClientOriginalName();

        $check=in_array($ext , $allowedExtensions);
        if($check){
            
        $path = 'uploads/slider/';
        $fileName = date('Y-m-d-h-i-s').'.'.$fileName;

      
            // $file->move(public_path().'/'.$path,$filename);
            Image::make($file)->resize(332, 431)->save(public_path().'/'.$path.$fileName , 90);
            // Image::make($file)->resize(254, 375)->save(public_path().'/'.$path.$fileName , 90);


            #--------------------

            #set value of sort
            $slider=new Slider;
           $slider->sliderImage= $path.$fileName;
           $slider->title1=$request->input('title1');
           $slider->title2=$request->input('title2');
           $slider->content=$request->input('content');
           $slider->sort=$request->input('sort');
           $slider->save();
        
           Session::flash('success' , "تمت الإضافة بنجاح");
           return Redirect::back();


        }else{
            Session::flash('fileErro' , "هذا النوع من الملفات غير مسموح به ");
            return Redirect::back();

        }//if
        
        }catch(Exception $ex){
            // Session::flash('error' , $ex."حدث خطأ أثناء الإضافة");
            throw($ex);
        }
        return Redirect::to('dashboard/slides');

  
 

    }//store
#End Store-------------------------------------------------------#
#--------------------------------------------------------------------------#

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if(!$id || Slider::where('sliderNo',$id)->count() == 0) {
    		return \App::abort(404);
    	}
        $slider=Slider::where('sliderNo' , $id)->first();
        return view('backend.slides.edit')->withslider($slider);
    }//edit

#End Edit-------------------------------------------------------#
#--------------------------------------------------------------------------#

    public function update($id ,Request $request )
    {
       if(!$id||Slider::where('sliderNo' , $id)->count()==0){
                  return \App::abort(404);
       }

       $request->validate(['title1' =>'regex:/^[ءa-zA-Zأ-ي\s]*$/u|required|min:6|max:15',
                                'title2' =>'regex:/^[ءa-zA-Zأ-ي\s]*$/u|required|min:10|max:30',
                                'content' =>'regex:/^[ءa-zA-Zأ-ي\s]*$/u|required|min:10|max:50',
                                'sort'=>'integer|min:0|max:10'
        ]);

        $file = $request->file('sliderImage');
        $allowedExtensions=['png' , 'jpg' ,'PNG','jpeg'];

        $ext=$file->getClientOriginalExtension();
        $fileName=$file->getClientOriginalName();
        $check=in_array($ext , $allowedExtensions);
        if($check){
       try{
            #------------- get info of selected slider  model did not kwor-----------------
       
            #---------------------------------------------------------------
            $row=DB::table('sliders')->where('sliderNo' ,$id);

#---------------- add image if selected 
        
            if($request->hasfile('sliderImage')){  
                
          
                    $path = 'uploads/slider/';
                    $fileName = date('Y-m-d-h-i-s').'.'.$fileName;
                        // $file->move(public_path().'/'.$path,$filename);
                        Image::make($file)->resize(332, 431)->save(public_path().'/'.$path.$fileName , 90);

                    #-------------------------------------  End image 
                    DB::table('sliders')->where('sliderNo' , $id)->update([ 'sliderImage' => $path.$fileName]);
            }// end image info
    

#--------------------------------------------------
            DB::table('sliders')
            ->where('sliderNo' , $id)
            ->update([
                'title1' => $request->input('title1'),
                'title2' => $request->input('title2'),
                'content' => $request->input('content'),
                'sort' => $request->input('sort'),
                'active' => $request->input('active')
                    ]);
                Session::flash('success' , "تم التعديل بنجاح   ");
                return Redirect::to('dashboard/slides');
            
                }catch(Exception $ex){
                Session::flash('error' ,$ex."حدث خطأ أثناء التعديل" );  
                return Redirect::to('dashboard/slides');
                }
    }else{
        Session::flash('fileErro' , "هذا النوع من الملفات غير مسموح به ");
        return Redirect::back();
        }


    }//update

  #end Update-------------------------------------------------------#
  #---------------------------------------------------------------------#

    public function destroy($id)
    {
        if(!$id || Slider::where('sliderNo',$id)->count() == 0) {
    		return \App::abort(404);
    	}
        try{
       
                $slider= DB::table('sliders')->where('sliderNo' , $id)->first();
                //delete file from public folder
                File::Delete( $slider->sliderImage);

                //delete row from database
                
                Slider::where('sliderNo' , $id)->delete();
                Session::flash('success' ,"تم الحذف بنجاح");

            }catch(Exception  $ex){
                Session::flash('error' ,$ex."حدث خطأ أثناء الحذف");
            }
     
    return Redirect::back();
    }//destroy
#End Edit Destroy-------------------------------------------------------#
#--------------------------------------------------------------------------#
}//ctrl



