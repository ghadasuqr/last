<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;
use Auth;
use App\Order;
use App\Cart;
use App\Shippinginfo;
use App\User;
use App\Itemimage;
use DB;
use Session;
use App\Feedback;
use App\Item;

class appBackCtrl extends Controller
{
     public function logoutBack(){

 
            Auth::logout();

            return redirect('/login');
        }


     public function adminIndex(){
        $items=DB::table('items')->where('active' , 0)->orderBy('code', 'DESC')->limit(4)->get();

        return view('backend.layouts.index')->withitems($items);

    }
#============================ users in admin sidebar================================ 
public function getUsersAdmin(){
    // $users=DB::table('users')->get();

    if(isset($_GET['q'])){
        $q=$_GET['q'];
        // $data=DB::table('imodels')->where('modelName' , 'LIKE ' ,'%'.$q.'%')->get();
        $users=User::where('name' , 'LIKE' ,'%'.$q.'%')
                     ->orwhere('mail', 'LIKE' ,'%'.$q.'%')
                      ->get();

    }else{
        $users=User::where('blocked' , 0)->get();
    }
   


    return view('backend.pages.activeUsers')->withusers($users);


}

#============================================================================
public function blockedUsersAdmin(){
    if(isset($_GET['q'])){
        $q=$_GET['q'];
        // $data=DB::table('imodels')->where('modelName' , 'LIKE ' ,'%'.$q.'%')->get();
        $users=User::where('name' , 'LIKE' ,'%'.$q.'%')
                    ->orwhere('mail', 'LIKE' ,'%'.$q.'%')                    
                    ->get();

    }else{
        $users=User::where('blocked' , 1)->get();
    }
   


    return view('backend.pages.blockedUsers')->withusers($users);
}
#=========================================================================================
public function blockUser($id)
{ 

    if(!$id||DB::table('users')->where('id' , $id)->count()==0){
        return \App::abort(404);
    }
    try{
    User::where('id' ,'=', $id)->update(['blocked' => 1]);
    Session::flash("success" , "تم  الاخفاء بنجاح");        

        }catch(\Exception $ex ){
            Session::flash("error" , $ex);
        }
        return  Redirect::to('dashboard/blockedUsers');


}//destroy
// =======================================================
public function activateUser($id)
{ 

    if(!$id||DB::table('users')->where('id' , $id)->count()==0){
        return \App::abort(404);
    }
    try{
    User::where('id' ,'=', $id)->update(['blocked' => 0]);
    Session::flash("success" , "تم  الاعادة  بنجاح");        

        }catch(\Exception $ex ){
            Session::flash("error" , $ex);
        }
        return  Redirect::to('dashboard/getUsers');


}//destroy
// ===============================================
public function updateRole(Request  $request, $id)
{ 
    $role=$request->input('role');

    if(!$id||DB::table('users')->where('id' , $id)->count()==0){
        return \App::abort(404);
    }
    try{
    User::where('id' ,'=', $id)->update(['Role' => $role]);
    Session::flash("success" , "تم  التعديل بنجاح");        

        }catch(\Exception $ex ){
            Session::flash("error" , $ex);
        }
        return  Redirect::to('dashboard/blockedUsers');


}//destroy
// ===========================================================Comments============================
public function getComments(){
    // $users=DB::table('users')->get();

    if(isset($_GET['q'])){
        $q=$_GET['q'];
        // $data=DB::table('imodels')->where('modelName' , 'LIKE ' ,'%'.$q.'%')->get();
        $comments=Feedback::where('comment' , 'LIKE' ,'%'.$q.'%')
                      ->get();

    }else{
        $comments=Feedback::where('comment' , '!=' ,"")->get();
    }
   


    return view('backend.pages.comments')->withcomments($comments);


}
#delete Comment-------------------------------------
public function deleteComment($id){
    try{

    
    $comments=Feedback::where('feedbackId' , $id)->update([ 'comment' => '']);
    Session::flash("success" , "تم   الحذف بنجاح");        

    }catch(Exception $ex){
        Session::flash("error" , " حدث خطأ اثناء الحذف");

    }
    return  Redirect::to('dashboard/comments');

}
#================================================================ End Comments====================================

// ================================================= Admin page ========================================= End most Rated section an admin page
static public function mostSoldToAdmin(){
    $items=DB::table('carts')
                    ->select('code' ,  DB::raw(' SUM(quantity) as totalQty ') )
                    ->where('IsOrdered' ,'=' ,1)
                    ->groupBy('code')
                    ->orderBy('totalQty' , 'DESC')
                    ->limit(3)
                    ->get();
    return $items;

}
// ====================================================================================== End Most Sold section in index admin 
 static public function mostRatedToAdmin(){
    $items=DB::table('feedbacks')
                        ->select('code' ,   DB::raw(' avg(points) as average ') )
                        ->groupBy('code')
                        ->orderBy('average' , 'DESC')                      
                        ->limit(3)
                        ->get();
    return $items;

}
// =========================================================================================== End Most Rated

 public function mostSoldAdminPage(){
     try{

     
    $data=DB::table('carts')
    ->select('code' ,  DB::raw(' SUM(quantity) as totalQty ') )
    ->where('IsOrdered' ,'=' ,1)
    ->groupBy('code')
    ->orderBy('totalQty' , 'DESC')
    // ->skip(3)
    ->paginate(4);
    

            return  view('backend.pages.mostSoldAdminPage')->withdata($data);
     }catch(\Exception $ex){
         throw $ex;
     }

 }
//  ========================================================================================

public function mostRatedAdminPage(){
    $data=DB::table('feedbacks')
    ->select('code' ,   DB::raw(' avg(points) as average ') )
    ->groupBy('code')
    ->orderBy('average' , 'DESC')                      
    ->paginate(3);
return view('backend.pages.mostRatedAdminPage')->withdata($data);
}
// =====================================================================================================
}//ctrl
