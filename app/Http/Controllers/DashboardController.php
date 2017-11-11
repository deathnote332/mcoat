<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Theme;

class DashboardController extends Controller
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
    public function index()
    {

        if($this->isMobile()){
            $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT');
            return $theme->scope('dashboard')->render();
        }else{
            $data = DB::table('month_sales')->where('_date',date('Y-m-d'))->first();
            $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
            return $theme->scope('dashboard',['data'=>($data != '' || $data != null) ? json_decode($data->data,TRUE) : ''])->render();
        }

    }
}
