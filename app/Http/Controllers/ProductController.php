<?php

namespace App\Http\Controllers;

use App\Product;
use App\TempProductout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Theme;
use PDF;
class ProductController extends Controller
{
    /**


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {

        $products = Product::orderBy('brand','asc')->orderBy('category','asc')->orderBy('description','asc')->orderBy('code','asc')->orderBy('unit','asc')->get();

        foreach($products as $key=>$val){


            $action = '<label id="add-to-cart" class="alert alert-info" data-id="'.$val->id.'" data-brand="'.$val->brand.'"
                        data-category="'.$val->category.'" data-code="'.$val->code.'" data-description="'.$val->description.'" data-quantity="'.$val->quantity.'" data-unit_price="'.$val->unit_price.'"
                        data-unit="'.$val->unit.'">Add to Cart</label>';
            $data[]=['brand'=>$val->brand,'category'=>$val->category,
                'description'=>$val->description,'code'=>$val->code,'unit'=>$val->unit,'quantity'=>$val->quantity,
                'quantity_1'=>$val->quantity_1,'unit_price'=>$val->unit_price,'action'=>$action];
        }
        return json_encode(['data'=>$data]);

        return json_encode(['data'=>$products]);
    }

    public function mcoatStocksPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('');
        return $theme->scope('mcoatstocks')->render();
    }

    public function alliedStocksPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('');
        return $theme->scope('alliedstocks')->render();
    }

    public function productoutPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('');
        return $theme->scope('productout')->render();
    }

    public function ajaxProductList(){
        return view('productout.productout');
    }

    public function ajaxCartList(){
        return view('productout.cart');
    }

    public function ajaxCartCount(){
        return view('productout.cartcount');
    }

    public function getCart(){
        $user_id = Auth::user()->id;
        $getCart = TempProductout::join('tblproducts','product_id','tblproducts.id')
            ->select('tblproducts.*','temp_product_out.qty as temp_qty','temp_product_out.id as temp_id')
            ->get();

        foreach($getCart as $key=>$val){

            $action = '<label class="alert alert-danger" data-id="'.$val->temp_id.'" data-product_id="'.$val->id.'" data-qty="'.$val->temp_qty.'" id="remove-cart">Remove</label>';
            $data[]=['brand'=>$val->brand,'category'=>$val->category,
                'description'=>$val->description,'code'=>$val->code,'unit'=>$val->unit,
                'temp_qty'=>$val->temp_qty,'unit_price'=>$val->unit_price,'total'=>$val->unit_price * $val->temp_qty,'action'=>$action];
        }
        return json_encode(['data'=>$data]);
    }

    public function  addToCart(Request $request){

        $product_id = $request->id;
        $product_qty = $request->qty;
        $newQty  = $request->current_qty - $product_qty;

        $temp = TempProductout::where('product_id',$product_id)->where('user_id',Auth::user()->id)->first();
        if(empty($temp)){
            TempProductout::insert(['product_id'=>$product_id,'user_id'=>Auth::user()->id,'qty'=>$product_qty]);
        }else{
            TempProductout::where('product_id',$product_id)->where('user_id',Auth::user()->id)->update(['qty'=>$temp->qty + $product_qty]);
        }
        //add to cart


        //minus to the current stock
        Product::where('id',$product_id)->update(['quantity'=>$newQty]);

    }

    public function removeToCart(Request $request){
       $temp_id= $request->temp_id ;
       $product_id= $request->product_id ;
       $qty= $request->qty ;

       //get current qty of this product
        $oldqty = Product::find($product_id)->quantity;
        $newQty = $oldqty + $qty;

        //update this product
        Product::where('id',$product_id)->update(['quantity'=>$newQty]);
        //delete temp
        TempProductout::where('id',$temp_id)->delete();
    }


    public function printInvoice(){

            $products = Product::join('temp_product_out','temp_product_out.product_id','tblproducts.id')
                ->select('temp_product_out.qty as temp_qty','tblproducts.*')
                ->get()->chunk(25);
            $product_arr = [];
            foreach($products as $key=> $val){
                array_push($product_arr,$val);
            }

//            DD($product_arr);
            $pdf = PDF::loadView('pdf.invoice',['products'=>$product_arr])->setPaper('a4')->setWarnings(false);
            return $pdf->stream();
//        return $pdf->download('invoice.pdf');


    }

}
