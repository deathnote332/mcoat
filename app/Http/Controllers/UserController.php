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
            $approved = '<label id="approve" class="alert alert-info" data-id="'.$val->id.'">Approved</label>';
            $disapproved = '<label id="approve" class="alert alert-danger" data-id="'.$val->id.'">Disapproved</label>';
            $userList[]=['email'=>$val->email,'name'=>$val->name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$approved.$disapproved];
        }

        return json_encode(['data'=>$userList]);
    }

    public function approveDisapproveUser(Request $request){
        User::where('id',$request->id)->update(['status',$request->status]);
    }
}
