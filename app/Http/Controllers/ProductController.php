<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Product;
use App\Productin;
use App\Productout;
use App\TempProductout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function getProducts(Request $request)
    {

        $products = Product::orderBy('brand','asc')->orderBy('category','asc')->orderBy('description','asc')->orderBy('code','asc')->orderBy('unit','asc')->get();
        $data=[];
        foreach($products as $key=>$val){

            $action = '<label id="add-to-cart" class="alert alert-info" data-id="'.$val->id.'" data-brand="'.$val->brand.'"
                        data-category="'.$val->category.'" data-code="'.$val->code.'" data-description="'.$val->description.'" data-quantity="'.$val->quantity.'" data-quantity_1="'.$val->quantity_1.'" data-unit_price="'.number_format($val->unit_price, 2).'"
                        data-unit="'.$val->unit.'">Add to Cart</label>';
            $data[]=['brand'=>$val->brand,'category'=>$val->category,
                'description'=>$val->description,'code'=>$val->code,'unit'=>$val->unit,'quantity'=>$val->quantity,
                'quantity_1'=>$val->quantity_1,'unit_price'=>'₱ '.number_format($val->unit_price, 2),'action'=>$action];
        }
        return json_encode(['data'=>$data]);

    }

    public function mcoatStocksPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT Stocks');
        return $theme->scope('mcoatstocks')->render();
    }

    public function alliedStocksPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Allied Stocks');
        return $theme->scope('alliedstocks')->render();
    }

    //mcoat productout
    public function productoutPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT Product out');
        return $theme->scope('productout')->render();
    }

    public function ajaxProductList(){
        return view('mcoat.productout.productout');
    }

    public function ajaxCartList(){
        return view('mcoat.productout.cart');
    }

    public function ajaxCartCount(){
        return view('mcoat.productout.cartcount');
    }

    public function ajaxReceiptCount(){
        $products = Product::join('temp_product_out','temp_product_out.product_id','tblproducts.id')
            ->select('temp_product_out.qty as temp_qty','tblproducts.*','temp_product_out.id as temp_id')
            ->where('temp_product_out.type',1)
            ->get()->chunk(25);
        return view('mcoat.productout.receiptcount',['receipt_count'=>count($products)]);

    }

    //allied productout
    public function alliedProductoutPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Allied Product out');
        return $theme->scope('alliedproductout')->render();
    }

    public function ajaxAlliedProductList(){
        return view('allied.productout.productout');
    }

    public function ajaxAlliedCartList(){
        return view('allied.productout.cart');
    }

    public function ajaxAlliedCartCount(){
        return view('allied.productout.cartcount');
    }

    public function ajaxAlliedReceiptCount(){
        $products = Product::join('temp_product_out','temp_product_out.product_id','tblproducts.id')
            ->select('temp_product_out.qty as temp_qty','tblproducts.*','temp_product_out.id as temp_id')
            ->where('temp_product_out.type',3)
            ->get()->chunk(25);
        return view('allied.productout.receiptcount',['receipt_count'=>count($products)]);

    }


    public function getCart(Request $request){

        $getCart = TempProductout::join('tblproducts','product_id','tblproducts.id')
            ->select('tblproducts.*','temp_product_out.qty as temp_qty','temp_product_out.id as temp_id')
            ->where('temp_product_out.type',$request->id)
            ->get();
        $data=[];
        foreach($getCart as $key=>$val){
            $action = '<label class="alert alert-danger" data-id="'.$val->temp_id.'" data-product_id="'.$val->id.'" data-qty="'.$val->temp_qty.'" id="remove-cart">Remove</label>';
            $data[]=['brand'=>$val->brand,'category'=>$val->category,
                'description'=>$val->description,'code'=>$val->code,'unit'=>$val->unit,
                'temp_qty'=>$val->temp_qty,'unit_price'=>number_format($val->unit_price, 2),'total'=>number_format($val->unit_price * $val->temp_qty, 2),'action'=>$action];
        }

        return json_encode(['data'=>$data]);
    }

    public function addToCart(Request $request){
        $type = $request->type;
        //product out
        $product_id = $request->id;
        $product_qty = $request->qty;
        $newQty  = $request->current_qty - $product_qty;


        //add to cart
        $temp = TempProductout::where('product_id',$product_id)->where('type',$type)->where('user_id',Auth::user()->id)->first();

        if(empty($temp)){
            TempProductout::insert(['product_id'=>$product_id,'user_id'=>Auth::user()->id,'qty'=>$product_qty,'type'=>$type]);
        }else{
            TempProductout::where('product_id',$product_id)->where('type',$type)->where('user_id',Auth::user()->id)->update(['qty'=>$temp->qty + $product_qty]);
        }


        if($type == 1){
            //minus to the current stock
            Product::where('id',$product_id)->update(['quantity'=>$newQty]);
        }elseif($type == 3){
            Product::where('id',$product_id)->update(['quantity_1'=>$newQty]);
        }


    }

    public function removeToCart(Request $request){
        $type = $request->type;

       $temp_id= $request->temp_id ;
       $product_id= $request->product_id ;
       $qty= $request->qty ;

       //get current qty of this product
        if($type == 1 || $type == 2){
            $oldqty = Product::find($product_id)->quantity;
        }elseif($type == 3 || $type == 4){
            $oldqty = Product::find($product_id)->quantity_1;
        }

        $newQty = $oldqty + $qty;

        if($type == 1 || $type == 2){
            //update this product
            Product::where('id',$product_id)->update(['quantity'=>$newQty]);
        }elseif($type == 3 || $type == 4){
            Product::where('id',$product_id)->update(['quantity_1'=>$newQty]);
        }

        //delete temp
        TempProductout::where('id',$temp_id)->delete();

        return number_format(TempProductout::join('tblproducts','temp_product_out.product_id','tblproducts.id')->where('temp_product_out.type',$type)->select(DB::raw('sum(temp_product_out.qty * tblproducts.unit_price) as total'))->first()->total,2);
    }


    public function saveProductout(Request $request){
        $type = $request->type;
        $branch_id = $request->branch_id;
        $products = Product::join('temp_product_out','temp_product_out.product_id','tblproducts.id')
            ->select('temp_product_out.qty as temp_qty','tblproducts.*','temp_product_out.id as temp_id')
            ->where('type',$type)
            ->get()->chunk(25);

        foreach($products as $key=> $product){
            $id = Productout::orderBy('id','desc')->first()->id + 1;

            if($type == 1){
                $receipt_title = 'MC-';
            }elseif($type == 3){
                $receipt_title = 'AP-';
            }

            $receipt =$receipt_title.date('Y').'-'.str_pad($id, 6, '0', STR_PAD_LEFT);

            $total = 0;
            foreach ($product as $key=>$val){
                $total = $total + $val->temp_qty *  $val->unit_price;
                $temp_id[]=$val->temp_id;
                //insert to product_out_items
                $insertProductoutITems = DB::table('product_out_items')->insert(['product_id'=>$val->id,'quantity'=>$val->temp_qty,'receipt_no'=>$receipt]);
            }
            //delete temp_product_out
            $deleteTempProductout = DB::table('temp_product_out')->wherein('id',$temp_id)->delete();
            Productout::insert(['receipt_no'=>$receipt,'total'=>$total,'branch'=>$branch_id,'printed_by'=>Auth::user()->id,'type'=>$type]);
            $rec_no[]=$receipt;
        }
        return $rec_no;

    }

    public function invoice(Request $request){

        $invoice = Productout::where('product_out.receipt_no',$request->id)->first();
        $products = DB::table('product_out_items')->join('tblproducts','tblproducts.id','product_out_items.product_id')->select('tblproducts.*','product_out_items.quantity as product_qty')->where('receipt_no',$request->id)->get();
        $data =['total'=>$invoice->total,'branch'=>$invoice->branch,'receipt_no'=>$invoice->receipt_no,'printed_by'=>$invoice->printed_by,'created_at'=>date('M d,Y',strtotime($invoice->created_at)),'products'=>$products];
        if($invoice->type == 1){
            $pdf = PDF::loadView('pdf.invoice',['invoice'=>$data])->setPaper('letter')->setWarnings(false);
        }else{
            $pdf = PDF::loadView('pdf.alliedinvoice',['invoice'=>$data])->setPaper('letter')->setWarnings(false);
        }

        return @$pdf->stream();

    }


    public function productInPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT Product in');
        return $theme->scope('productin')->render();
    }

    public function ajaxProductInList(){
        return view('mcoat.productin.productin');
    }


    public function ajaxCartInList(){
        return view('mcoat.productin.cartin');
    }

    public function ajaxCartInCount(){
        return view('mcoat.productin.cartcountin');
    }

    //allied productin
    public function productAlliedInPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Allied Product in');
        return $theme->scope('alliedproductin')->render();
    }

    public function ajaxAlliedProductInList(){
        return view('allied.productin.productin');
    }


    public function ajaxAlliedCartInList(){
        return view('allied.productin.cartin');
    }

    public function ajaxAlliedCartInCount(){
        return view('allied.productin.cartcountin');
    }



    public function saveProductin(Request$request){
        $receipt_no = $request->receipt_no;
        $supplier_id = $request->supplier_id;
        $id = Productin::insertGetId(['receipt_no'=>$receipt_no,'supplier_id'=>$supplier_id,'entered_by'=>Auth::user()->id,'warehouse'=>$request->type]);

        $getAllinTemp = TempProductout::where('type',$request->type)->where('user_id',Auth::user()->id)->get();

        foreach ($getAllinTemp as $key=>$val) {
            DB::table('product_in_items')->insert(['product_id'=>$val->product_id,'quantity'=>$val->qty,'receipt_no'=>$receipt_no,'product_in_id'=>$id]);

            //getoldqty of product

            if($request->type == 2){
                $oldqty = Product::find($val->product_id)->quantity;
            }else{
                $oldqty = Product::find($val->product_id)->quantity_1;
            }

            $newqty = $oldqty + $val->qty;

            if($request->type == 2){
                Product::where('id',$val->product_id)->update(['quantity'=>$newqty]);
            }else{
                Product::where('id',$val->product_id)->update(['quantity_1'=>$newqty]);
            }

        }
        //delete
        TempProductout::where('type',$request->type)->where('user_id',Auth::user()->id)->delete();
    }


    public function invoiceReceiptin(Request $request){

        $producin_items = DB::table('product_in_items')->join('tblproducts','tblproducts.id','product_in_items.product_id')->select('tblproducts.*','product_in_items.quantity as product_qty')->where('product_in_items.product_in_id',$request->id)->get();

        $invoice = Productin::where('id',$request->id)->first();
        $data =['receipt_no'=>$invoice->receipt_no,'supplier_id'=>$invoice->supplier_id,'warehouse'=>$invoice->warehouse,'entered_by'=>$invoice->entered_by,'created_at'=>date('M d,Y',strtotime($invoice->created_at)),'products'=>$producin_items];

        $pdf = PDF::loadView('pdf.receiptin',['invoice'=>$data])->setPaper('letter')->setWarnings(false);
        return @$pdf->stream();

    }


    //manage product
    public function manageProduct(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('');
        return $theme->scope('manageproducts')->render();
    }

    public function addNewProduct(Request $request){
        $quantity = ($request->type == 1) ? 'quantity' : 'quantity_1';
        Product::insert(['brand'=>$request->brand,'category'=>$request->category,
            'code'=>$request->code,'description'=>$request->description,'unit'=>$request->unit,$quantity=>$request->quantity,'unit_price'=>(double) str_replace(',', '', $request->unit_price)]);
    }

    public function updateProduct(Request $request){
        $quantity = ($request->type == 1) ? 'quantity' : 'quantity_1';
        Product::where('id',$request->product_id)->update(['brand'=>$request->brand,'category'=>$request->category,
            'code'=>$request->code,'description'=>$request->description,'unit'=>$request->unit,$quantity=>$request->quantity,'unit_price'=>(double) str_replace(',', '', $request->unit_price)]);
    }

    public function fastMovingProducts(){
        $graph = Productout::groupBy('branch')->select('branch',DB::raw('COUNT(receipt_no) as total_receipt'))->get();
        $totalReceipt = Productout::count();
        $data = array();
        foreach ($graph as $key=>$val){
            $percentage = ($val->total_receipt / $totalReceipt) * 100;
            $data[]=['label'=>Branches::find($val->branch)->name,'value'=>number_format($percentage,1)];
        }
       return $data;
    }

    //allied manage product
    public function alliedManageProduct(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('');
        return $theme->scope('alliedmanageproducts')->render();
    }
}
