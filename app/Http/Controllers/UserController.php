<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Theme;

class UserController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userPage()
    {

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('users')->render();
    }

    public function getUsers(){
        $users = User::get();
        $userList = array();
        foreach ($users as $key => $val){
            $userList[]=['email'=>$val->email,'name'=>$val->name,'created_at'=>date('M d,Y',strtotime($val->created_at))];
        }

        return json_encode(['data'=>$userList]);
    }
}
