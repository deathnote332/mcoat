<?php

namespace App\Http\Controllers;

use App\Employee;
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
        $this->middleware('guest');
    }

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

    public function saveBioData(Request $request){
        $data = json_encode($request->all());
        Employee::insert(['record'=>$data]);


    }
}
