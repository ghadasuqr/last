<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    static public function itemsINsale($saleNo){
           $items=Sale::where('saleNo' , $saleNo)->first();
           $itemsInsale=array();
           $itemsInsale=json_decode($items->itemsINsale); // decode &   encode
           return $itemsInsale;
    }
     static  public function rightDate($date){
        $rightDate= explode(' ',$date)[0] ;
        // $rightDate=str_replace('-','/', $date);                  
        // $rightDate=date("m/d/Y", strtotime($date));
        return $rightDate;
     }
     static  public function dateToEdit($date){
      $editDate=str_replace('-','/', $date);                  
      $editDate=date("m/d/Y", strtotime($date));
      return $editDate;
   }
     static  public function isCurrentSale($saleNo){
   $date=date('Y-m-d');
   $data=Sale::where('saleNo' , $saleNo)
   ->where('startDate' , '<=',$date)
   ->where('endDate' , '>=',$date)        
   ->get();  
      return count($data);
     }

     static function NotYetSale($saleNo){
      $date=date('Y-m-d');
      $data=Sale::where('saleNo' , $saleNo)
      ->where('startDate' , '>',$date)         
      ->get();  
         return count($data);
        }

        static function finished($saleNo){
         $date=date('Y-m-d');
         $data=Sale::where('saleNo' , $saleNo)
         ->where('endDate' , '<',$date)         
         ->get();  
            return count($data);
           }
      // =========================================================
     static  function isactive($saleNo){
      if (self::isCurrentSale($saleNo)  == 1) {
         echo 'جارى ';}
     
     if (self::NotYetSale($saleNo)  == 1) {
      echo 'مستقبل';}

      if (self::finished($saleNo)  == 1) {
         echo 'انتهى';}
  }
   // =========================================================


   static public  function isCurrent($item){
      $date=date('Y-m-d');   
      $data=Sale::where('startDate' , '<=',$date)
            ->where('endDate' , '>=',$date)        
            ->get();
            foreach($data as $Key =>$sale){
            $items=json_decode($sale->itemsINsale);
                        if(in_array($item , $items)){
                           return $sale->percentageValue;
               }//foreach
     }//if

}
// ========================= end isCurrent
// ========================= DURATION  of current sales  if found ========================================
//1- min start date   
static public function duration(){
  $date=date('Y-m-d');   
      
   $minStart=Sale::where('startDate' , '<=',$date)->where('endDate' , '>=',$date)->min('startDate');

     
   $maxEnd=Sale::where('startDate' , '<=',$date)->where('endDate' , '>=',$date)->max('endDate');   


  $duration=  date_diff(   date_create($minStart)  , date_create($maxEnd)  )->format("%a") ;
  return $duration;

 }//
 static public function EndedAT(){
   $date=date('Y-m-d');   
       
    $minStart=Sale::where('startDate' , '<=',$date)->where('endDate' , '>=',$date)->min('startDate');
 
      
    $maxEnd=Sale::where('startDate' , '<=',$date)->where('endDate' , '>=',$date)->max('endDate');   
 
 
   $endedAt=  date_diff(   date_create($date)  , date_create($maxEnd)  )->format("%a") ;
   return $endedAt;
 
  }//duration
 static public function maxDiscount(){
   $date=date('Y-m-d');   
      
   $maxDisount=Sale::where('startDate' , '<=',$date)->where('endDate' , '>=',$date)->max('percentageValue');
   return $maxDisount;
 }
}//
