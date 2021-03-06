<?php

namespace App\Http\Controllers;

use App\Branches;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Theme;
class SaleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function saveDailySale(Request $request){

        $check = DB::table('month_sales')->where('_date',date('Y-m-d'))->first();
        if($check != null ||  $check != '' ){
            $data = $request->all();
            unset($data['_token']);
            $_data = json_encode($data);
            DB::table('month_sales')->where('_date',date('Y-m-d'))->update(['data'=>$_data]);
            $message = 'Successfully updated sale today.';

        }else{
            $data = $request->all();
            unset($data['_token']);
            $_data = json_encode($data);
            DB::table('month_sales')->insert(['branch_id'=>Auth::user()->branch_id,'_date'=>date('Y-m-d'),'data'=>$_data]);
            $message = 'Successfully saved sale today.';
        }

        return $message;

    }


    public function editDailySale(Request $request){

        $date = date('Y-m-d', strtotime($request->_date));
        $branch= $request->branch;
        $check = DB::table('month_sales')->where('branch_id',$request->branch_id)->where('_date',$date)->first();
        if($check != null ||  $check != '' ){
            $data = $request->all();
            unset($data['_token']);



            $_data = json_encode($data);
            DB::table('month_sales')->where('_date',$date)->update(['data'=>$_data]);
            $message = 'Successfully updated sale today.';

        }else{
            $data = $request->all();
            unset($data['_token']);
            $_data = json_encode($data);
            DB::table('month_sales')->insert(['branch_id'=>Auth::user()->branch_id,'_date'=>$date,'data'=>$_data,'branch_id'=>$request->branch_id]);
            $message = 'Successfully saved sale today.';
        }

        return $message;

    }

    public function getMonthlySales(Request $request){
        $data = DB::table('month_sales')->where(DB::raw('MONTH(_date)'),DB::raw('MONTH(NOW())'))->get();
        foreach ($data as $key => $val){
            $_data[] = ['day'=>date('M d, Y' ,strtotime($val->_date)),'receipt_no'=>json_decode($val->data,TRUE)['receipt_no']
                ,'total_amount'=>'₱ '.number_format(json_decode($val->data,TRUE)['total_amount'],2),'deposit_amount'=>'₱ '.number_format(json_decode($val->data,TRUE)['deposit_amount'],2)
            ,'taken_amount'=>'₱ '.number_format(json_decode($val->data,TRUE)['taken_amount'],2),'expenses'=>'₱ '.number_format(json_decode($val->data,TRUE)['expenses_amount'],2).' | '.json_decode($val->data,TRUE)['expenses_description']];
        }
        return json_encode(['data'=>$_data]);
    }


    public function yearSale(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Sales report');
        return $theme->scope('salesreport')->render();

    }

    public function monthDay(Request $request){
        $start_date = $request->year.'-'.$request->month.'-1';
        $end_date = date('t',strtotime($start_date));
        $month = $request->month;
        $year = $request->year;
        $branch = $request->branch;

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Sales report');
        return $theme->of('sales.permonth',['start_date'=>$start_date,'end_date'=>$end_date,'month'=>$month,'year'=>$year,'branch'=>$branch])->render();

    }


    public function ajaxSalesMonth(Request $request){


        if($request->year == date('Y')){
            $month_count = date('m');
        }else{
            if($request->year > date('Y')){
                $month_count = 0;
                 abort(503);
            }elseif($request->year < date('Y')){
                $month_count = 12;
            }
        }

        $data_total = [
            'branch'=>$request->branch,
            'year'=>$request->year,
            'month_count'=>$month_count,
        ];

        return view('ajax.sales-month',$data_total);
    }
}
