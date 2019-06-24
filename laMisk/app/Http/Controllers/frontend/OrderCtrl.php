<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use Redirect;
use DB;
use Auth;
use App\Favorite;
use App\Cart;
use App\Order;
use App\Shippinginfo;
use App\Invoice;
class OrderCtrl extends Controller
{
    public function create(){
        return view('frontend.orders.checkout');
        
    }
    public function store(){


    }

#  1- start Cart=========================================================


public function cart(){
    if(!Auth::check()){   return Redirect::to('login');    }
$data=DB::table('carts')->where('user_id' , Auth::User()->id)->where('IsOrdered' ,'0')->get();
// $data=DB::table('favorites')->where('userId' , Auth::User()->id)->get();
        return view('frontend.orders.cart', compact('data'));
}
# 2-  start add To cart=====================================================
public function addToCart(Request $request){
    $price=$request->input('price');
    $code=$request->input('code');
    $modelNo=$request->input('modelNo');
    $itemDescription=$request->input('itemDescription');
    $color=$request->input('color');
    $size=$request->input('size');    
    
    #validation

    $request->validate([
        'color' => 'required',
        'size' => 'required'
    ]);
    #validation

    // if found 
    $myFound=DB::table('carts')
    ->where('user_id' , Auth::User()->id)
    ->where('code' , $code)
    ->where('modelNo' , $modelNo)
    ->where('color' , $color)
    ->where('size' , $size)
    ->get();
    if( count($myFound) !==0){
        $item=DB::table('items')->where('code' ,$code)->first();
        Session::flash('error' ,$item->itemDescription.'         '.'  '.$size.'    '.$color.'  '.' تمت   اضافته   مسبقا ');
        return Redirect::to('cart');
    }else{
            try{
                $row= new Cart;
                $row->code=$code;
                $row->modelNo=$modelNo;
                $row->user_id=Auth::User()->id;
                $row->price=$price;
                $row->color=$request->input('color');
                $row->size=$request->input('size');        
                $row->save();
                Session::flash('success' , 'تمت الاضافة بنجاح');
            // return Redirect::to('cart');

            }catch(Exception $ex){
                 Session::flash('error' , 'حدث خطأ اثناء الإضافة');
            }
        return Redirect::to('cart');

    }//else if count 
}//add to cart 

# END add To cart------------------------------------------------------
// ================================================================================================================

# Start update cart------------------------------------------------------

public function updateCart(Request $request){
    $user_id=Auth::User()->id;
    $code=$request->code;
    $quantity=$request->quantity;
    $subtotal=0;
    $total=0;
    try{
        $cart=Cart::where('code' , $code)->where('user_id' ,$user_id)->first();
        $cart->quantity=$quantity;
        $cart->save();
        $status=true;
        //calcuklate subtotal
        $subtotal=$cart->price*$cart->quantity;
        //calculate Total
        $data=Cart::where('user_id' ,$user_id)->where('IsOrdered' , 0)->get();


        foreach($data as $singledata){
            $total +=$singledata->price * $singledata->quantity;
        }


    }catch(Exception $ex){
        

    }
    return response()->json(['success'=>$status ,'subtotal' =>$subtotal , 'total' =>$total]);


}
# END update cart------------------------------------------------------

#4- start destroy Cart========================================================================================
public function CartDestroy($id){
    try{
        Cart::where('id' , $id)->delete();
    Session::flash('success' , "تم الحذف بنجاح");

    }catch(Excption $ex){
        Session::flash('error' , "  حدث خطا اثناء الحذف");
    }
    return Redirect::to('cart');
}//destroy

# End destroy ---------------------------------------------------------End cart

#Start ckeckout===========================================================================================================================
#================================================================================================================================================
### 1- show shippng  details to order
public function OrderCart(){
#check if not authorized 

if(!Auth::check()){return Redirect::to('login');}

#get data if user login and cart is not ordered yet

$data=DB::table('carts')->where('user_id' , Auth::User()->id)->where('IsOrdered' ,'0')->get();
return view('frontend.orders.checkout' , compact('data'));

}// OrderCart

### 2- Strat storOrderCart  ###===============================================================================

public function storeOrderCart(Request $request){
    
$request->validate([
'receverName' =>'required|min:2|max:60|regex:/^[a-zA-Zأ-ي\s]*$/u' ,
'receverPhone' =>'required' ,
'country' =>'required|min:2|max:70' ,
'city' =>'required|min:2|max:50' ,
'town' =>'required|min:2|max:50' ,
'address' =>'required|min:6|max:200' ,
]);

try{
    DB::beginTransaction();
    #transaction gurantees that 2 oprations of saving will happened alltogether
 
#1- save order table data
    $order= new Order;
    $cart_id=array();
    $data=DB::table('carts')->where('user_id' , Auth::User()->id)->where('IsOrdered' ,0)->get();
    // $cart_id=DB::table('carts')->where('user_id' , Auth::User()->id)->where('IsOrdered' ,'0')->pluck('id');  ... another true way 

    foreach($data as $key =>$row){
        $cart_id[]=$row->id;
    }
if(count ($cart_id) >0 ){
    $order->user_id=Auth::User()->id;
    $order->cart_id=json_encode($cart_id);   //or implode 
    $order->save();
    $lastOrderId=Order::max('orderNo');
    $invoice=new Invoice();
    $invoice->orderNo=$lastOrderId;
#2-Update isOrdered field in carts table 
foreach($cart_id as $id){
    DB::table('carts')->where('id' , $id)->update(['isOrdered' =>1]); // update carts table
    }
#3- save shippnigInfo  table data
$shippinginfo=new Shippinginfo;
$shippinginfo->orderNo=$lastOrderId;
$shippinginfo->userId=Auth::User()->id;
$shippinginfo->receiverName=$request->input('receiverName');
$shippinginfo->receiverPhone=$request->input('receiverPhone');
$shippinginfo->country=$request->input('country');
$shippinginfo->city=$request->input('city');
$shippinginfo->town=$request->input('town');
$shippinginfo->address=$request->input('address');
$shippinginfo->save();


# 4- update cart status from 0 to 1


// decrease counts 
foreach($cart_id as $id){
    $cart=Cart::where('id' , $id)->first();
                 
    $color=$cart->color;
    $code=$cart->code;
    $size=$cart->size;
    $quantity=$cart->quantity;

    $row = DB::table('colors')->where('code', $code)->where('color' , $color)->first(); //get color of item
        
    $data=  DB::table('sizes')->where('id_color' , $row->id)->where('size' , $size)->first();  // get size
    $oldCount=$data->count; // get quantity of this size
    DB::table('sizes')->where('id_color' , $row->id)->where('size' , $size)->update(['count' => $oldCount - $quantity]);  
}

DB::commit();

Session::flash('orderNo' , $lastOrderId);
Session::flash('successO' , "تم ارسال الطلب بنجاح    ");

return Redirect::to ('successO/'.$lastOrderId);




}else{
    Session::flash('error' , " لا توجد طلبات مرسلة   ");
    return Redirect::back();
}
#5-decreas count of sizes for that item
#6-invoice page ===========================================================================================

#6-invoice page ===========================================================================================


}catch(\Exception $ex){
    Session::flash('error' , "حدث خطأ أثناء الارسال ");
    #if problem happened
    DB::rollback();
    return Redirect::back();
    // return view('orders.successO')->withorderNo($orderNo)

}




}//store order cart
#End ckeckout===========================================================================================================================
#================================================================================================================================================


public function invo($id)
{
    return view('frontend.orders.successO')->withid($id);
}


}//ctrl
