<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Product;
use App\Productin;
use Illuminate\Http\Request;
use Theme;

class MobileProductController extends Controller
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
    public function index()
    {

        $products = Product::orderBy('brand','asc')->orderBy('category','asc')->orderBy('description','asc')->orderBy('code','asc')->orderBy('unit','asc')->get();
        $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT');
        return $theme->scope('mobile.products',['data'=>$products])->render();
    }

}
