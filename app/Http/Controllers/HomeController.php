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
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $theme = Theme::uses('default')->layout('default')->setTitle('MCOAT');
        return $theme->of('home')->render();
    }
}
