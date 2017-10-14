<?php

namespace App\Http\Controllers;

use App\Employee;
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

        $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT');
        return $theme->scope('mobile.products')->render();
    }

}
