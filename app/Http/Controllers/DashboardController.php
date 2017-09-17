<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;

class DashboardController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('dashboard')->render();
    }
}
