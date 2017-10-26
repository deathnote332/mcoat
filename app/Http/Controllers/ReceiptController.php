<?php

namespace App\Http\Controllers;

use App\DeletedItem;
use App\Product;
use App\Productin;
use App\Productout;
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
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('WEEKOFYEAR(product_out.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('DATE(product_out.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where(DB::raw('YEAR(product_out.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_out.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
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
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where(DB::raw('WEEKOFYEAR(product_out.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where(DB::raw('DATE(product_out.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productout::orderBy('product_out.id','desc')
                    ->where('product_out.type',$type)
                    ->where(DB::raw('YEAR(product_out.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_out.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('branches','product_out.branch','branches.id')
                    ->join('users','product_out.printed_by','users.id')
                    ->select('product_out.id','product_out.receipt_no','product_out.total','product_out.created_at','users.first_name','users.last_name','branches.name')
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
                $edit = "<a href='editReceipt/$data->receipt_no'><label id='edit-receipt' class='alert alert-warning' >Edit</label></a>";
                $delete = "<a><label id='delete-receipt' class='alert alert-danger' data-id='$data->receipt_no' >Delete</label></a>";

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
                    ->select('product_in.*','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('WEEKOFYEAR(product_in.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('DATE(product_in.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where(DB::raw('YEAR(product_in.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_in.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }


        }else{

            if($request->_range == 'all'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }elseif($request->_range == 'week'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('WEEKOFYEAR(product_in.created_at)'),DB::raw('WEEKOFYEAR(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();

            }elseif($request->_range == 'today'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('DATE(product_in.created_at)'),DB::raw('curdate() + INTERVAL 1 DAY'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }elseif($request->_range == 'month'){
                $receipts = Productin::orderBy('product_in.id','desc')
                    ->where('product_in.entered_by',Auth::user()->id)
                    ->where(DB::raw('YEAR(product_in.created_at)'),DB::raw('YEAR(NOW())'))
                    ->where(DB::raw('MONTH(product_in.created_at)'),DB::raw('MONTH(NOW())'))
                    ->join('suppliers','product_in.supplier_id','suppliers.id')
                    ->join('users','product_in.entered_by','users.id')
                    ->select('product_in.id','product_in.receipt_no','product_in.created_at','users.first_name','users.last_name','suppliers.name')
                    ->get();
            }

        }


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
                return ($data->warehouse == 2) ? 'MCOAT Pasig Warehouse' : 'Dagupan Warehouse';
            })
            ->addColumn('action', function ($data) use ($request){
                $view = "<a href='invoiceReceiptin/$data->id' target='_blank'><label id='view-receipt' class='alert alert-success' data-id='.$data->id.'>View</label></a>";
                return $view;
            })
            ->make(true);

    }

    public function editReceipt(Request $request)
    {
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('editreceipts',['receipt_no'=>$request->id,'type'=>Productout::where('receipt_no',$request->id)->first()->type])->render();
    }

    public function getcartReceipt(Request $request)
    {
        $receipt = $request->receipt_no;
        $getReceiptData= DB::table('product_out_items')->join('tblproducts','product_out_items.product_id','tblproducts.id')
            ->select('tblproducts.*','product_out_items.quantity as temp_qty','product_out_items.id as temp_id')
            ->where('product_out_items.receipt_no',$receipt)
            ->get();

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
        $products = DB::table('product_out_items')->join('tblproducts','product_out_items.product_id','tblproducts.id')
            ->select('product_out_items.quantity as temp_qty','tblproducts.*','product_out_items.id as temp_id')
            ->where('product_out_items.receipt_no',$receipt_no)
            ->get()->chunk(20);

        return view('productout.receiptcount',['receipt_count'=>count($products)]);

    }

    public function editAddToCart(Request $request){

        $product_id = $request->id;
        $product_qty = $request->qty;
        $newQty  = $request->current_qty - $product_qty;

        //add to cart
        $product_out_items = DB::table('product_out_items')->where('product_id',$product_id)->where('receipt_no',$request->receipt_no)->first();
        if(empty($product_out_items)){
            DB::table('product_out_items')->insert(['product_id'=>$product_id,'quantity'=>$product_qty,'receipt_no'=>$request->receipt_no]);
        }else{
            DB::table('product_out_items')->where('product_id',$product_id)->where('receipt_no',$request->receipt_no)->update(['quantity'=>$product_out_items->quantity + $product_qty]);
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
        $oldqty = Product::find($product_id)->quantity;
        $newQty = $oldqty + $qty;

        Product::where('id', $product_id)->update(['quantity' => $newQty]);

        //delete temp
        DB::table('product_out_items')->where('id', $temp_id)->delete();

        //update receipt
        $total = DB::table('product_out_items')->join('tblproducts', 'tblproducts.id', 'product_out_items.product_id')->where('product_out_items.receipt_no', $request->receipt_no)->select(DB::raw('sum(product_out_items.quantity * tblproducts.unit_price) as total'))->first()->total;
        Productout::where('receipt_no', $request->receipt_no)->update(['total' => $total]);

        return number_format($total, 2);
    }


    //stocksreport

    public function stocksReport(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('stocksreport')->render();
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

        $queryBrand = $request->brand;
        $queryCategory =  $request->category;
        $queryDescription =  $request->description;
        $queryUnit = $request->unit;
        $queryStock = $request->stock;
        if($queryStock == 0){
            $stock =[0];
        }elseif($queryStock == 1){
            $stock = [1,2,3];
        }else{
            $stock = '';
        }

       //not empty brand
       if($queryUnit == 'na' && $queryCategory == 'na' && $queryDescription =='na' && $queryBrand != 'na') {

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
       }elseif($queryBrand == 'na' && $queryCategory != 'na' && $queryDescription == 'na' && $queryUnit == 'na'){

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
       //not empty description
       }elseif($queryBrand == 'na' && $queryCategory== 'na' && $queryDescription != 'na' && $queryUnit == 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('description',$queryDescription)
               ->get();
           $title = $queryDescription;
        //not empty unit
       }elseif($queryBrand == 'na' && $queryCategory== 'na' && $queryDescription== 'na' && $queryUnit != 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryUnit;
       //not empty brand and category
       }elseif($queryBrand != 'na' && $queryCategory != 'na' && $queryDescription =='na' && $queryUnit =='na'){

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
       //not empty brand and description
       }elseif($queryBrand != 'na' && $queryCategory=='na' && $queryDescription !='na' && $queryUnit=='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('description',$queryDescription)
               ->get();
           $title = $queryBrand.'-'.$queryDescription;
        //not empty brand and unit
       }elseif($queryBrand != 'na' && $queryCategory=='na' && $queryDescription =='na' && $queryUnit != 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryBrand.'-'.$queryUnit;
        //not empty category and description
       }elseif($queryBrand == 'na' && $queryCategory != 'na' && $queryDescription != 'na' && $queryUnit =='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('category',$queryCategory)
               ->where('description',$queryDescription)
               ->get();
           $title = $queryCategory.'-'.$queryDescription;
        //not empty category and unit
       }elseif($queryBrand =='na' && $queryCategory !='na' && $queryDescription =='na' && $queryUnit !='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('category',$queryCategory)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryCategory.'-'.$queryUnit;
        //not empty description and unit
       }elseif($queryBrand == 'na' && $queryCategory =='na' && $queryDescription != 'na' && $queryUnit != 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('description',$queryDescription)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryDescription.'-'.$queryUnit;
        //not empty brand and description and unit
       }elseif($queryBrand != 'na' && $queryCategory =='na' && $queryDescription != 'na' && $queryUnit != 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('description',$queryDescription)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryBrand.'-'.$queryDescription.'-'.$queryUnit;
        //not empty brand  and category and unit
       }elseif($queryBrand != 'na' && $queryCategory != 'na' && $queryDescription =='na' && $queryUnit != 'na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('description',$queryDescription)
               ->where('category',$queryCategory)
               ->get();
           $title = $queryBrand.'-'.$queryCategory.'-'.$queryUnit;
        //not empty brand  and category and description
       }elseif($queryBrand != 'na' && $queryCategory != 'na' && $queryDescription != 'na' && $queryUnit =='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('description',$queryDescription)
               ->where('category',$queryCategory)
               ->get();
           $title = $queryBrand.'-'.$queryCategory.'-'.$queryDescription;
       //not empty category  and description and unit
       }elseif($queryBrand =='na' && $queryCategory != 'na' && $queryDescription != 'na' && $queryUnit !='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('category',$queryCategory)
               ->where('description',$queryDescription)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryDescription.'-'.$queryDescription.'-'.$queryUnit;
        //not empty all
       }elseif($queryBrand != 'na' && $queryCategory !='na' && $queryDescription != 'na' && $queryUnit !='na'){
           $products = Product::orderBy('brand')
               ->orderBy('category')
               ->orderBy('description')
               ->orderBy('unit')
               ->when($stock, function ($query) use ($stock) {
                   return $query->whereIn($this->queryString(), $stock);
               })
               ->where('brand',$queryBrand)
               ->where('description',$queryDescription)
               ->where('category',$queryCategory)
               ->where('unit',$queryUnit)
               ->get();
           $title = $queryBrand.'-'.$queryDescription.'-'.$queryDescription.'-'.$queryUnit;
       }

        $data = ['data'=>$products,'title'=>$title];
        $pdf = PDF::loadView('pdf.stocklist',$data)->setPaper('a4');
        return @$pdf->stream();
    }




}
