<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';


    static public  function Average($code){
        $average=Feedback::where('code' , $code)->avg('points');
        return $average;
    }
}
