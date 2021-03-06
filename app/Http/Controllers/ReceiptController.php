<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Product;
use App\Productin;
use App\Productout;
use App\TempProductout;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Theme;
use Yajra\Datatables\Facades\Datatables;
class ReceiptController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function receipt()
    {
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('receipts')->render();
    }

    public function getReciepts(Request $request){

        if(Auth::user()->user_type ==1){
            if($request->_range == 'all'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('WEEKOFYEAR(product_out.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('DATE(product_out.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('YEAR(product_out.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_out.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }
        }else{
            if(Auth::user()->warehouse == 1){
                $type = 1;
            }elseif(Auth::user()->warehouse == 2){
                $type=3;
            }

            if($request->_range == 'all'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where('product_out.printed_by',Auth::user()->id)
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where('product_out.printed_by',Auth::user()->id)
                    ->where(DB::raw('WEEKOFYEAR(product_out.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where('product_out.printed_by',Auth::user()->id)
                    ->where(DB::raw('DATE(product_out.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where('product_out.printed_by',Auth::user()->id)
                    ->where(DB::raw('YEAR(product_out.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_out.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.*','users.first_name','users.last_name','branches.name')
                    ->where('product_out.status',1)
                    ->get();
            }

        }

        return Datatables::of($receipts)
            ->addColumn('receipt_no', function ($data) use ($request){
                return $data->receipt_no;
            })
            ->addColumn('delivered_to', function ($data) use ($request){

                return $data->name;
            })
            ->addColumn('total', function ($data) use ($request){
                return '₱ '.number_format($data->total, 2);
            })
            ->addColumn('created_by', function ($data) use ($request){

                return $data->first_name.' '.$data->last_name;

            })
            ->addColumn('created_at', function ($data) use ($request){
                return date('M d,Y',strtotime($data->created_at));
            })
            ->addColumn('action', function ($data) use ($request){
                $view = "<a href='invoice/1/$data->receipt_no' target='_blank'><label id='view-receipt' class='alert alert-success' >View</label></a>";
                $edit = "<a><label id='edit-receipt' data-receipt='$data->receipt_no' class='alert alert-warning' >Edit</label></a>";
                $delete = "<a><label id='delete-receipt' class='alert alert-danger' data-id='$data->id' data-receipt='$data->receipt_no' data-type='$data->type'>Delete</label></a>";

                return $view.$edit.$delete;
            })

            ->make(true);

//
//        $receiptData =array();
//        foreach ($receipts as $key=>$val){
//
//
//            $receiptData[]=['receipt_no'=>$val->receipt_no,'delivered_to'=>Branches::find($val->branch)->name,'total'=>'₱ '.number_format($val->total, 2),'created_by'=>User::find($val->printed_by)->first_name.' '.User::find($val->printed_by)->last_name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$view.$edit];
//        }
//
//        return json_encode(['data'=>$receiptData]);
    }

    public function receiptin()
    {
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('receiptsin')->render();
    }

    public function getRecieptsIn(Request $request){

        if(Auth::user()->user_type ==1){


            if($request->_range == 'all'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->leftjoin('suppliers','product_in.supplier_id','suppliers.id')
                    ->leftjoin('users','product_in.entered_by','users.id')
                    ->select('product_in.*','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('WEEKOFYEAR(product_in.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('DATE(product_in.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('YEAR(product_in.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_in.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }


        }else{

            if($request->_range == 'all'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('WEEKOFYEAR(product_in.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('DATE(product_in.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('YEAR(product_in.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_in.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name','product_in.warehouse as wr')
                    ->get();
            }

        }

        if(!is_null($receipts)){
            return Datatables::of($receipts)
                ->addColumn('receipt_no', function ($data) use ($request){
                    return $data->receipt_no;
                })
                ->addColumn('delivered_from', function ($data) use ($request){
                    return $data->name;

                })
                ->addColumn('created_by', function ($data) use ($request){
                    return $data->first_name.' '.$data->last_name;
                })
                ->addColumn('created_at', function ($data) use ($request){
                    return date('M d,Y',strtotime($data->created_at));
                })
                ->addColumn('warehouse', function ($data) use ($request){
                    return ($data->wr == 2) ? 'MCOAT Pasig Warehouse' : 'Dagupan Warehouse';
                })
                ->addColumn('action', function ($data) use ($request){
                    $view = "<a href='invoiceReceiptin/$data->id' target='_blank'><label id='view-receipt' class='alert alert-success' data-id='.$data->id.'>View</label></a>";
                    return $view;
                })
                ->make(true);
        }



//        $data = array();
//        foreach($receipts as $key=>$val){
//            $view = "<a href='invoiceReceiptin/$val->id' target='_blank'><label id='view-receipt' class='alert alert-success' data-id='.$val->id.'>View</label></a>";
//            $data[]=['receipt_no'=>$val->receipt_no,'delivered_from'=>$val->name,'created_by'=>$val->first_name.' '.$val->last_name,'created_by'=>date('M d,Y',strtotime($val->created_at)),'warehouse'=>($val->wr == 2) ? 'MCOAT Pasig Warehouse' : 'Dagupan Warehouse','action'=>$view];
//        }
//
//        return json_encode(['data'=>$data]);

    }

    public function editReceipt(Request $request)
    {
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('editreceipts',['receipt_no'=>$request->id,'type'=>Productout::where('receipt_no',$request->id)->first()->type])->render();
    }

    public function ajaxSaveToTemp(Request $request){
        //move product_out items into temp_product_out

        //delete first if data existed
        $temp_product_out = DB::table('temp_product_out')->where('rec_no',$request->receipt_no)->delete();
        //get all receipt items
        $product_out_items = DB::table('product_out_items')->where('receipt_no',$request->receipt_no)->get();
        //insert to temp but don't delete original data
        //type 5 for editing receipt
        foreach ($product_out_items as $key=>$val){
            DB::table('temp_product_out')->insert(['product_id'=>$val->product_id,'qty'=>$val->quantity,'type'=>5,'user_id'=>Auth::user()->id,'rec_no'=>$val->receipt_no]);
        }
    }

    public function updateReceipt(Request $request){
        $products = DB::table('temp_product_out')
            ->where('type',5)
            ->where('user_id',Auth::user()->id)
            ->where('rec_no',$request->receipt_no)
            ->get();
        //delete product_out_items
        $product_out_items = DB::table('product_out_items')->where('receipt_no',$request->receipt_no)->delete();

        foreach ($products as $key=>$val){
            DB::table('product_out_items')->insert(['product_id'=>$val->product_id,'quantity'=>$val->qty,'receipt_no'=>$val->rec_no]);
        }
        $total =  TempProductout::join('tblproducts','temp_product_out.product_id','tblproducts.id')->where('temp_product_out.rec_no',$request->receipt_no)->where('temp_product_out.type',5)->where('temp_product_out.user_id',Auth::user()->id)->select(DB::raw('sum(temp_product_out.qty * tblproducts.unit_price) as total'))->first()->total;
        //update product_out
        Productout::where('receipt_no',$request->receipt_no)->update(['total'=>$total,'branch'=>$request->branch_id]);

        //delete temp items
        $temp_product_out = DB::table('temp_product_out')->where('rec_no',$request->receipt_no)->delete();

    }

    public function getcartReceipt(Request $request)
    {

//        $receipt = $request->receipt_no;
        $getReceiptData= DB::table('temp_product_out')->join('tblproducts','temp_product_out.product_id','tblproducts.id')
            ->select('tblproducts.*','temp_product_out.qty as temp_qty','temp_product_out.id as temp_id')
            ->where('temp_product_out.rec_no',$request->receipt_no)
            ->get();
//
        $data=[];
        foreach($getReceiptData as $key=>$val){
            $action = '<label class="alert alert-danger" data-id="'.$val->temp_id.'" data-product_id="'.$val->id.'" data-qty="'.$val->temp_qty.'" id="remove-cart">Remove</label>';
            $data[]=['brand'=>$val->brand,'category'=>$val->category,
                'description'=>$val->description,'code'=>$val->code,'unit'=>$val->unit,
                'temp_qty'=>$val->temp_qty,'unit_price'=>'₱ '.number_format($val->unit_price, 2),'total'=>'₱ '.number_format($val->unit_price * $val->temp_qty, 2),'action'=>$action];
        }

        return json_encode(['data'=>$data]);
    }

    public function ajaxEditProductList(Request $request){
        if($request->type == 3){
            return view('editreceipt.editproductallied');
        }else{
            return view('editreceipt.editproductlist');
        }
    }
    public function ajaxEditCartList(Request $request){
        return view('editreceipt.editcart',['receipt_no'=>$request->receipt_no]);
    }

    public function ajaxCartCount(Request $request){
        return view('editreceipt.cartcount',['receipt_no'=>$request->receipt_no]);
    }

    public function ajaxEditReceiptCount(Request $request){
        $receipt_no = $request->receipt_no;
        $products = Product::join('temp_product_out','temp_product_out.product_id','tblproducts.id')
            ->select('temp_product_out.qty as temp_qty','tblproducts.*','temp_product_out.id as temp_id')
            ->where('temp_product_out.type',5)
            ->where('temp_product_out.user_id',Auth::user()->id)
            ->where('rec_no',$receipt_no)
            ->get()->chunk(25);

        return view('mcoat.productout.receiptcount',['receipt_count'=>count($products)]);

    }

    public function editAddToCart(Request $request){

        $product_id = $request->id;
        $product_qty = $request->qty;
        $newQty  = $request->current_qty - $product_qty;

        //add to cart
        $temp_product_out = DB::table('temp_product_out')->where('product_id',$product_id)->where('rec_no',$request->receipt_no)->first();
        if(empty($temp_product_out)){
            DB::table('temp_product_out')->insert(['product_id'=>$product_id,'qty'=>$product_qty,'rec_no'=>$request->receipt_no,'type'=>5,'user_id'=>Auth::user()->id]);
        }else{
            DB::table('temp_product_out')->where('product_id',$product_id)->where('rec_no',$request->receipt_no)->update(['qty'=>$temp_product_out->qty + $product_qty]);
        }
        //minus to the current stock
        $type = ($request->type == 1) ? 'quantity' : 'quantity_1';
        Product::where('id',$product_id)->update([$type=>$newQty]);

    }

    public function editRemoveToCart(Request $request)
    {


        $temp_id = $request->temp_id;
        $product_id = $request->product_id;
        $qty = $request->qty;

        //get current qty of this product

        if($request->type == 3){
            $oldqty = Product::find($product_id)->quantity_1;
            $newQty = $oldqty + $qty;
            Product::where('id', $product_id)->update(['quantity_1' => $newQty]);
        }else{
            $oldqty = Product::find($product_id)->quantity;
            $newQty = $oldqty + $qty;
            Product::where('id', $product_id)->update(['quantity' => $newQty]);
        }


        //delete temp
        DB::table('temp_product_out')->where('id', $temp_id)->delete();

        //update receipt
        $total =  TempProductout::join('tblproducts','temp_product_out.product_id','tblproducts.id')->where('temp_product_out.type',5)->select(DB::raw('sum(temp_product_out.qty * tblproducts.unit_price) as total'))->where('user_id',Auth::user()->id)->first()->total;

        return number_format($total, 2);
    }


    //stocksreport

    public function stocksReport(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('stocksreport')->render();
    }


    public function stockListAll(Request $request){
        ini_set("memory_limit", "999M");
        ini_set("max_execution_time", "999");
        $products = Product::orderBy('brand')
            ->orderBy('category')
            ->orderBy('description')
            ->orderBy('unit')
            ->offset($request->offset)
            ->limit(300)
            ->get();


        $title = 'All stocks';
        $data = ['data'=>$products,'title'=>$title];
        $pdf = PDF::loadView('pdf.stocklist',$data)->setPaper('a4');
        return $pdf->download('stocklist.pdf');

    }

    public function priceList(Request $request){
        if(empty($request->category)){
            $products = Product::where('brand',$request->brand)
                ->orderBy('brand')
                ->orderBy('category')
                ->orderBy('description')
                ->orderBy('unit')
                ->get();
            $title = $request->brand;
        }else{
            $products = Product::where('brand',$request->brand)->where('category',$request->category)->orderBy('brand')
                ->orderBy('category')
                ->orderBy('description')
                ->orderBy('unit')
                ->get();
            $title = $request->brand.' - '.$request->category;
        }


        $data = ['data'=>$products,'title'=>$title];

        $pdf = PDF::loadView('pdf.pricelist',$data)->setPaper('a4')->setWarnings(false);
        return @$pdf->stream();
    }

    public function brandCategory(Request $request){

        $products = Product::where('brand', $request->brand)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('ajax.category', ['data' => $products]);
    }


    public function stockList(Request $request){
       // dd($request->all());
        $queryBrand = $request->brand;
        $queryCategory =  $request->category;
        $queryStock = $request->stock;
        if($queryStock == 0){
            $stock =[0];
        }elseif($queryStock == 1){
            $stock = [1,2,3];
        }else{
            $stock = '';
        }

       //not empty brand
       if($queryCategory == '' && $queryBrand != '') {

           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand', $queryBrand)
               ->get();
           $title = $queryBrand;
       //not empty category
       }elseif($queryBrand == '' && $queryCategory != ''){

           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('category',$queryCategory)
               ->get();
           $title = $queryCategory;
       //not empty brand and category
       }elseif($queryBrand != '' && $queryCategory != ''){

           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('category',$queryCategory)
               ->get();
           $title = $queryBrand.'-'.$queryCategory;
       }
        $data = ['data'=>$products,'title'=>$title,'warehouse'=>$request->warehouse];
        $pdf = PDF::loadView('pdf.stocklist',$data)->setPaper('a4');
        return @$pdf->stream();
    }


}
