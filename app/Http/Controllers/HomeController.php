<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;

class HomeController extends Controller
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

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('mcoatstocks')->render();
    }
}
