<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
  protected $table = 'categories';
      static public function getNameCatById($categoryNo){

        $row = category::where('categoryNo',$categoryNo)->first();
        $obj=$row->categoryName;
        return $obj;
    }
}
