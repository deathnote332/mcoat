<?php

namespace App\Http\Controllers;

use App\Branches;
use App\DeletedItem;
use App\Supplier;
use App\User;
use Illuminate\Http\Request;
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
        $suppliers = Supplier::orderBy('name','asc')->get();
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
        $branches = Branches::orderBy('name','asc')->get();
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

        $check = DeletedItem::where('type',$request->type)->first();

        if(empty($check)){
            $arr[]= json_decode(json_encode(Supplier::find($request->id)),TRUE);
            DeletedItem::insert(['data'=> json_encode(['data'=>$arr]),'type'=>$request->type]);
        }else{
            $old_data  =  json_decode($check->data,TRUE);
            $old_data['data'][] = json_decode(json_encode(Supplier::find($request->id)),TRUE);
            $data = json_encode($old_data);
            DeletedItem::where('type',$request->type)->update(['data'=> $data]);
        }

        if($request->type == 3){
            Supplier::where(['id'=>$request->id])->delete();
        }elseif($request->type == 2){
            Branches::where(['id'=>$request->id])->delete();
        }

    }

}
