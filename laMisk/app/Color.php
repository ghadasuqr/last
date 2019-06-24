<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
   static public function getItemColors($id){

         $colors=Color::where('code' ,  $id)->get();
         return $colors;
     }
     static public function getItemColors_itself($id){
        $colors_itself =array();

        $colors=Color::where('code' ,  $id)->get();
        foreach($colors as $key=>$color){
            $colors_itself[]=$color->color;
        }
        return $colors_itself;
    }//fun
}
