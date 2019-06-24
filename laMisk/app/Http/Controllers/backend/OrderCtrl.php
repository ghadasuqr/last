<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use App\Order;
use App\Cart;
use App\Shippinginfo;
use App\User;
use App\Itemimage;
use DB;
use Auth;


class OrderCtrl extends Controller
{
    
    public function index(){
         $data=Order::get();
         return view('backend.orders.list' , compact('data'));
         
     }

    public function new(){
         $data=Order::where('status' , 0)->get();
         return view('backend.orders.new' , compact('data'));

     }

     public function pending(){
        $data=Order::where('status' , 1)->get();
        return view('backend.orders.pending' , compact('data'));

     }
     
     public function returned(){
      $data=Order::where('isReturned' , 1)->get();
      return view('backend.orders.returned' , compact('data'));

   }

     public function completed(){
        $data=Order::where('status' , 2)->get();
        return view('backend.orders.completed' , compact('data'));


     }

     #===================================================== updatae status and shipper==================================================== newstatus fn 
     public function newstatus(Request $request , $orderNo){
$request->validate(['status' =>'required' ,
                      'shipperNo' =>'required']);
        $status=$request->input('status');
        $shipperNo=$request->input('shipperNo');
        try{
           DB::table('orders')->where('orderNo' , $orderNo)->update(['status' =>$status , 'shipperNo' =>$shipperNo]);
        Session::flash('success' ,"تم التعديل بنجاح");

      }catch(Exception  $ex){
          Session::flash('error' ,$ex."حدث خطأ أثناء التعديل");
      }

return Redirect::back();


   }
   
     #===================================================== updatae status and shipper====================================================


     public function viewOrderDetails($orderId){
         $orderId=$orderId;
        $data=Order::where('orderNo' , $orderId)->first();
        $cart_Ids=array();
        $cart_Ids=json_decode($data->cart_id);
       $user_shipping_info=Shippinginfo::where('orderNo' , $orderId)->first();
      
       return view('backend.orders.details')
               ->withuserInfo($user_shipping_info)
               ->withcartIds($cart_Ids)
               ->withorderId($orderId);
     }
// ========================== to shipper ================================//
// ========================== to shipper ================================//
// 1-=========================================================================================== Index shipper fn
public function shipperIndex(){
   $data=Order::where('shipperNo' ,Auth::User()->id)->where('isReturned' , 0 )->get(); //choose ordered for this shipper while   not returned yet 
   return view('backend.layouts.shipper')->withdata($data);
}

//2- =================================================================================================== Details fn
     public function OrderDetailsToShipper($orderId){

      $data=Order::where('orderNo' , $orderId)->first();
      $cart_Ids=array();
      $cart_Ids=json_decode($data->cart_id);
     $user_shipping_info=Shippinginfo::where('orderNo' , $orderId)->first();
     $orderNo=$orderId;
    
     return view('backend.orders.detailsToShipper')
             ->withuserInfo($user_shipping_info)
             ->withcartIds($cart_Ids)
             ->withorderNo($orderNo);
   }
   # 3- =================== Return  Order Function  FOr Shipper======================================= Return  orders fn
   
   public function return(Request $request, $orderNo){
      $data=Order::where('orderNo' , $orderNo)->first();    
      $cart_Ids=json_decode($data->cart_id);

      $returndIds=array(); // fill array 
      foreach($cart_Ids as $key =>$Id){
         if ($request->has('returnedItem'.$key)){
            $returndIds[]=$request->input('returnedItem'.$key);
         }
      }
      // ======================================================================= work with new cart Id to add items in items list  
      try{
      if( count ($returndIds)  >0 ){
                  foreach($returndIds as $key =>$cartId){
                     $cart=Cart::where('id' , $cartId)->first();
                     #update cartid to be returned 
                     DB::table('carts')->where('id' , $cartId)->update(['isReturned' => 1]);
                     #update cartid to be returned 
                     #upadte count in size table                      
                     $color=$cart->color;
                     $code=$cart->code;
                     $size=$cart->size;
                     $quantity=$cart->quantity;

                     $row = DB::table('colors')->where('code', $code)->where('color' , $color)->first(); //get color of item
                           
                     $data=  DB::table('sizes')->where('id_color' , $row->id)->where('size' , $size)->first();  // get size
                     $oldCount=$data->count; // get quantity of this size
                     DB::table('sizes')->where('id_color' , $row->id)->where('size' , $size)->update(['count' => $quantity+$oldCount]);
                   }//foreach cartId
  #= in  OrderTable ======================= =============================================================== Make Order Returned 
               DB::table('orders')->where('orderNo' , $orderNo)->update( ['isReturned' => 1]);
               Session::flash('success' , "تم الارجاع بنجاح");
               return Redirect::to('dashboard/shipper')  ;




           }else{
            Session::flash('request' , " يجب اختيار منتج على الاقل");
            return Redirect::back()  ;


               }

      }catch(Exception $ex){

         Session::flash('error' , "حدث خطأ أثناء الارجاع");
         return Redirect::to('dashboard/shipper')  ;

      }

   }//fun Return

   
   #=================================================== ُEnd  Return  Order Function ==========================
   #=================================================== ُOrders TO Ship =======================================
   public function ToShip(){
      $data=Order::where('status' , 2)->where('isReturned' , 0)->where('shipperNo' , Auth::User()->id)->get();
      return view('backend.orders.completeToShip' , compact('data'));
   }
 #=================================================== ُOrders Details  TO Ship =======================================
 
 public function viewOrderDetailsToShip($orderId){
   $orderId=$orderId;
  $data=Order::where('orderNo' , $orderId)->first();
  $cart_Ids=array();
  $cart_Ids=json_decode($data->cart_id);
 $user_shipping_info=Shippinginfo::where('orderNo' , $orderId)->first();

 return view('backend.orders.detailsToShip')
         ->withuserInfo($user_shipping_info)
         ->withcartIds($cart_Ids)
         ->withorderId($orderId);
}
// ========================== End  shipper ================================//
// ==========================  End shipper ================================//



# ======================================== destroy============================================== desroy fn

     public function delete($id)
     {
      
             try{
               DB::beginTransaction();
               //  cart
               $data=Order::where('orderNo' , $id)->first();
               $cart_Ids=array();
               $cart_Ids=json_decode($data->cart_id);
               foreach($cart_Ids as $cartId){
                  Cart::where('id' , $cartId)->delete();
               }
               // shipping adddress
                  Shippinginfo::where('orderNo' , $id)->delete();
               // order   
                 Order::where('orderNo' , $id)->delete();
                 DB::commit();
 
                 Session::flash('success' , 'تم الحذف بنجاح');
             }catch(Exception $ex){
                throw($ex);
                DB::rollback();
             }
             return Redirect::back();
 
     }//desrroy
     
}
