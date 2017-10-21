<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
            return $theme->scope('dashboard')->render();
        }

    }
}
