<?php

namespace App\Http\Controllers\frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use App\category;
use App\Item;
use App\Feedback;
use DB;
use Session;
use Redirect;
class productsCtrl extends Controller
{
    // products page ------------------============================================  الاقسام ==========================
    public function index(){
        $data=category::where('active' , 0)->get();
        $items=DB::table('items')->where('active' ,'=' , 0)->get();

      
        return view ('frontend.pages.products')->withdata($data)->withitems($items);
    }
    public function modelItems($modelNo){
        $data=category::where('active' , 0)->get();
        $data=category::get();
        $items=DB::table('items')->where('modelNo' , $modelNo)->where('active' ,'=' , '0')->get();
        return view ('frontend.pages.products')->withdata($data)->withitems($items);


    }
    public function sizColor(){
        #---sidebar
        $data=category::where('active' , 0)->get();
   
        #---sidebar
    if(isset($_GET['filter'])){

        try{
        // inputs=============
        $color=$_GET['color'];
        $size=$_GET['size'];
        $min=$_GET['min'];
        $max=$_GET['max'];

        $items=  DB::table('items')
  
        ->join('colors', 'items.code', '=', 'colors.code')
        ->join('sizes', 'colors.id', '=', 'sizes.id_color')
        ->select('items.code', 'items.itemDescription','items.price' , 'items.modelNo' )
        ->where('active' ,'=' , '0')      
        ->whereBetween('items.price', array($min, $max))
       ->where('colors.color', '=' , $color)
       ->where('sizes.size' , '=' , $size)
        ->get();
        return view ('frontend.pages.products')->withdata($data)->withitems($items);
        }catch(\Exception $ex){
            Session::flash('msg' , "error");
            return Redirect::to('products/search');


        }//catch

    }//if
    }//sizeColor
    // products page----------------------------------------------------------------------------------End
    // ==================================================== ProductDetails Page=====================================
    public function productDetails($code){
        $item=DB::table('items')->where('code',$code)->first();
        return view('frontend.products.productDetails')->withitem($item);
    }
    #===================================================  DID NOT Paginate   ====================================
    public function latestPage(){
        
        $items=DB::table('items')->where('active' , 0)->orderBy('code', 'DESC')->paginate(4);
        return  view('frontend.products.latestPage')->withitems($items);
    }//
    // ========================================================================= MostSoldPage  =====================
    public function mostSold(){
        $items=DB::table('carts')
                        ->select('code' ,   DB::raw(' SUM(quantity) as totalQty ') )
                        ->where('IsOrdered' ,'=' ,1)
                        ->groupBy('code')
                        ->orderBy('totalQty' , 'DESC')
                        ->paginate(4);
                   
    return view('frontend.products.mostSold')->withitems($items);

    }
// ======================================== show in index (Home page) ===================================================
  static public function mostSoldToIndex(){
        $items=DB::table('carts')
                        ->select('code' ,   DB::raw(' SUM(quantity) as totalQty ') )
                        ->where('IsOrdered' ,'=' ,1)
                        ->groupBy('code')
                        ->orderBy('totalQty' , 'DESC')
                        ->limit(4)
                        ->get();
        return $items;

    }
    
//============================================================= Search page==========================================================
public static function search(){
    if(isset($_GET['search'])){
        try{
            $search=$_GET['search'];
            // $items=DB::table('items')
            $items=  DB::table('items')
        ->join('imodels', 'items.modelNo', '=', 'imodels.modelNo')
        ->join('categories', 'categories.categoryNo', '=', 'imodels.categoryNo')
        
        ->select('items.code', 'items.itemDescription','items.price' , 'items.modelNo' )
        ->where('active' , '=' , 0)
            ->where('itemDescription' ,'LIKE' ,'%'.$search.'%')
            ->orwhere('materialType1' ,'LIKE' , '%'.$search.'%')
            ->orwhere('materialType2' ,'LIKE' , '%'.$search.'%')
            ->orwhere('modelName' ,'LIKE' , '%'.$search.'%')
            ->orwhere('categoryName' ,'LIKE' , '%'.$search.'%')
            ->paginate(8);


            return view('frontend.products.search')->withitems($items)->withsearch($search);

        }catch(Exception $ex){
            return view('frontend.products.search');
            Session::flash('error' , "wrong");

        }//catch
    }//if
}//fn
#========================================================================================================
public function mostRated(){
    $items=DB::table('feedbacks')
                        ->select('code' ,   DB::raw(' avg(points) as average ') )
                        ->groupBy('code')
                        ->orderBy('average' , 'DESC')                      
                        ->paginate(4);
                        return view('frontend.products.mostRated')->withitems($items);

}
#===========================================================================
public function modern(){
$category="مودرن";
    $items=DB::table('items')
    ->where('active' , 0)
    ->join('imodels' ,'items.modelNo','=','imodels.modelNo')
    ->join('categories' ,'imodels.categoryNo','=','categories.categoryNo')
    ->where('categries.categoryName' , '=' ,$category)
    ->orderBy('code', 'DESC')
    ->paginate(2);
    return  view('frontend.products.latestPage')->withitems($items);
}//

}//ctrl
