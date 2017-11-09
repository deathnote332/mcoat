<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Product;
use App\Productout;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Theme;

class SupplierBranchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function supplierPage()
    {

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('suppliers')->render();
    }

    public function getSuppliers(){
        $suppliers = Supplier::orderBy('name','asc')->where('status',1)->get();
        $supplierList = array();
        foreach ($suppliers as $key => $val){
            $edit = '<label id="update" class="alert alert-warning" data-id="'.$val->id.'" data-name="'.$val->name.'" data-address="'.$val->address.'">Edit</label>';
            $delete = '<label id="delete" class="alert alert-danger" data-id="'.$val->id.'">Delete</label>';
            $supplierList[]=['name'=>$val->name,'address'=>$val->address,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$edit.$delete];
        }

        return json_encode(['data'=>$supplierList]);
    }


    public function updateSupplier(Request $request){

        Supplier::where('id',$request->id)->update(['name'=>$request->name,'address'=>$request->address]);
    }

    public function branchPage()
    {

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('branches')->render();
    }


    public function getBranches(){
        $branches = Branches::orderBy('name','asc')->where('status',1)->get();
        $branchesList = array();
        foreach ($branches as $key => $val){
            $edit = '<label id="update" class="alert alert-warning" data-id="'.$val->id.'" data-name="'.$val->name.'" data-address="'.$val->address.'">Edit</label>';
            $delete = '<label id="delete" class="alert alert-danger" data-id="'.$val->id.'">Delete</label>';

            $branchesList[]=['name'=>$val->name,'address'=>$val->address,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$edit.$delete];
        }
        return json_encode(['data'=>$branchesList]);
    }

    public function updateBranch(Request $request){

        Branches::where('id',$request->id)->update(['name'=>$request->name,'address'=>$request->address]);
    }

    public function deleteItems(Request $request){

        if($request->type == 1){
            User::where('id',$request->id)->update(['is_remove'=>0]);
        }elseif($request->type == 2){
            Branches::where('id',$request->id)->update(['status'=>0]);
        }elseif($request->type == 3){
            Supplier::where('id',$request->id)->update(['status'=>0]);
        }elseif($request->type == 4){
           Productout::where('id',$request->id)->update(['status'=>0]);
            $message = $this->returnQuantity($request->rec_no,$request->warehouse);
        }elseif($request->type == 5){
            Product::where('id',$request->id)->update(['status'=>0]);
            //notification
            $warehouse = ($request->warehouse== 1) ? 'M-Coat Warehouse' : 'Allied Warehouse';
            $user = Auth::user()->first_name.' '.Auth::user()->last_name;
            $product = Product::find($request->id);
            $product = 'Brand:'.$request->brand.' Category:'.$product->category.' Code:'.$product->code.' Description:'.$product->description.' Unit:'.$product->unit.' Quantity: '.$product->quantity.' Unit Price:'.$product->unit_price ;
            DB::table('notifications')->insert(['message'=>$user.' deleted product( '.$product.' ) in '.$warehouse]);
        }
    }


    public function branchSalePage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Branch Sales');
        return $theme->scope('sales')->render();
    }

}
