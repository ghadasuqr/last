<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 use Session;
 use Redirect;
 use App\Sale;
 use App\Item;
class saleCtrl extends Controller
{

    public function index()
    {

        if(isset($_GET['q'])){
            $q=$_GET['q'];
                    if(!empty($q)){
                        $q=date_create($_GET['q']);           
              }
                        $Data=Sale::where('startDate' ,'<=' ,$q )->where('endDate' ,'>=' ,$q)->get();
        }else

        $Data=Sale::orderBy('startDate', 'desc')->get();
        return view('backend.sale.list')->withData($Data);
    }

    public function create()
    {
        return view('backend.sale.create');
    }

    public function store(Request $request)
    {
     $request->validate([
        'startDate'=>'required',
        'endDate' =>'required',
        'percentageValue'=>'required|numeric|min:1|max:99' ,
        'items'  =>'required' ])  ;
        // $startDate=date_create($request->startDate);
       $startDate= explode(' ',$request->startDate)[0];
       $endDate= explode(' ',$request->endDate)[0];
        $code=$request->items;
        // $endDate=date_create($request->endDate);
        // $today=date_create(date("y-m-d"));

        // $diff->format("%R%a") <= 0
        $today=date("Y-m-d");
   
       
        // $diff=date_diff($startDate,$endDate); //diff= enddate - startDate

        if ($startDate < $today){
      
            Session::flash('errorStart'  , " يجب أن  لا يقل تاريخ البداية عن  تاريخ  اليوم  ") ;
            return Redirect::back();   
         } elseif( $startDate >=$endDate   ){

            Session::flash('errorEnd'  , " يجب ان يكون تاريخ الانتهاء اكبر من تاريخ البداية  ") ;

            return Redirect::back();

               }else{
                        try{
                                $sale=new Sale ;
                                $sale->startDate=$startDate;
                                $sale->percentageValue=$request->percentageValue;
                                $sale->endDate=$endDate;  
                                $sale->itemsINsale=json_encode($request->items);
                                $sale->save();                              
                                Session::flash('success'  , "تمت الاضافة بنجاح ") ;   
                            }catch(\Exception $ex){
                                Session::flash('success'  ,$ex. "حدث خطأ أثناء الاضافة   ") ;
                            }
                   return Redirect::to('dashboard/sales');
                } //else
    }
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        
        if(!$id||Sale::where('saleNo' , $id)->count()== 0){
            return \App::abort(404);  }   
     // ---------------------------------------------------
        $sale=Sale::where('saleNo' , $id)->first();
        $itemsINsale=json_decode($sale->itemsINsale);
  
        return view('backend.sale.edit')->withsale($sale)->withitemsINsale($itemsINsale);
    
    }


    public function update(Request $request, $id)

    {
        
        if(!$id||Sale::where('saleNo' , $id)->count()== 0){
            return \App::abort(404);  }   
        // ----------------------------------------------------
        $request->validate([
            'startDate'=>'required',
            'endDate' =>'required',
            'percentageValue'=>'required|numeric|min:1|max:99' ,
            'items'  =>'required' ])  ;
            // $startDate=date_create($request->startDate);
    
            $code=$request->items;
            // $endDate=date_create($request->endDate);
            // $today=date_create(date("y-m-d"));
            $startDate= explode(' ',$request->startDate)[0];
             $endDate= explode(' ',$request->endDate)[0];
             $today=date('Y-m-d');
           
            // $diff=date_diff($startDate,$endDate); //diff= enddate - startDate
    
            if ($startDate < $today){
          
                  Session::flash('errorStart'  , " يجب أن  لا يقل تاريخ البداية عن  تاريخ  اليوم  ") ;
                  return Redirect::back();   
             } elseif( $startDate >=$endDate   ){
    
                Session::flash('errorEnd'  , " يجب ان يكون تاريخ الانتهاء اكبر من تاريخ البداية  ") ;
    
                return Redirect::back();
    
                   }else{

                            try{
                                $items=array();
                                $items=json_encode($request->items) ;

                                \DB::table('sales')->where('saleNo' , $id)->update([
                                            'startDate'=> $startDate,
                                            'endDate'=> $endDate,
                                           'itemsINsale'=> $items                   
                                    ]);
 
                                                  
                         Session::flash('success'  , "تم التعديل بنجاح ") ;   
                                }catch(\Exception $ex){
                                    Session::flash('error'  , "حدث خطأ أثناء التعديل   ") ;
                                }
                       return Redirect::to('dashboard/sales');
                    } //else
      
       

    }//update



    public function destroy($id)
    {

        if(!$id||Sale::where('saleNo' , $id)->count()== 0){
            return \App::abort(404);  }   
            #----------------------------------
            try{
            
                Sale::where('saleNo' , $id)->delete();


                Session::flash('success' , 'تم الحذف بنجاح');
            }catch(Exception $ex){
               Session::flash('error','حدث خطأ اثناء الحذف');
            }
     return Redirect::to('dashboard/sales');

    }
}
