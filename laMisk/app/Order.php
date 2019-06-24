<?php

namespace App;
use App\ShippingInfo;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    static public function TotalForOrder($cart_Id){  //array of cartId  was given
        $total=0;
        $carts=json_decode($cart_Id);
   
        if(   count(json_decode($cart_Id)  )  > 0){
            foreach($carts as $key => $id){
            
                $cart=Cart::where('id' , $id)->first();  
                if($cart){
                    $total+=$cart->price*$cart->quantity;
                }//if cart 
            }//foreach
            return $total;
         }//if 


    }//fun

    static public function status($status){
        $info="";
        switch ($status) {
            case 0:
            $info="جديد";
                break;
            case 1:
            $info="تجهيز";
            break;
            case 2:
            $info="مكتمل";
                break;
            
            default:
            $info="";

        } 
return $info;
    }
    static public function isReturned($isReturned){
        $info="";
        switch ($isReturned) {
            case 0:
            $info=" ";
                break;
            case 1:
            $info="ارجاع";
            break;
       
            
            default:
            $info="";

        } 
return $info;
    }


    static public function retuneOrder($orderId){
     $order=Order::where('orderNo' , $orderId)->where('isReturned' , 1)->first();
        if($order){
            echo '      <th scope="col">  رجع  </th>';
        }
    }

    static public function cartIds($orderId){
 
        $data=Order::where('orderNo' , $orderId)->first();

        $cart_Ids=json_decode($data->cart_id);

        return $cart_Ids;        
    }//cartIds fn 
    static public function userInfo($orderNo){
        $userInfo=Shippinginfo::where('orderNo' , $orderNo)->first();
        return $userInfo;
    }
}
