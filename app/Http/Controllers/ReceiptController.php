<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Productout;
use App\User;
use Illuminate\Http\Request;
use Theme;

class ReceiptController extends Controller
{

    public function receipt()
    {
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('receipts')->render();
    }

    public function getReciepts(Request $request){

        $receipts = Productout::all();

        $receiptData =array();
        foreach ($receipts as $key=>$val){

            $view = "<a href='invoice/$val->receipt_no' target='_blank'><label id='view-receipt' class='alert alert-success' data-id='.$val->id.'>View</label></a>";
            $edit = '<label id="edit-receipt" class="alert alert-warning data-id="'.$val->id.'">Edit</label>';

            $receiptData[]=['receipt_no'=>$val->receipt_no,'delivered_to'=>Branches::find($val->branch)->name,'total'=>'₱ '.number_format($val->total, 2),'created_by'=>User::find($val->printed_by)->name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$view.$edit];
        }

        return json_encode(['data'=>$receiptData]);
    }
}
