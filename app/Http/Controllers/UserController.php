<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Theme;

class UserController extends Controller
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
    public function userPage()
    {

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('users')->render();
    }

    public function getUsers(){
        $users = User::get();
        $userList = array();
        foreach ($users as $key => $val){
            $approved = '<label id="approve" class="alert alert-info" data-id="'.$val->id.'"  data-approve="1">Change to approve</label>';
            $disapproved = '<label id="approve" class="alert alert-danger" data-id="'.$val->id.'" data-approve="0">Change to disapprove</label>';

            $admin = '<label id="admin" class="alert alert-info" data-id="'.$val->id.'"  data-approve="1">Appoint admin</label>';
            $revoke = '<label id="admin" class="alert alert-danger" data-id="'.$val->id.'" data-approve="2">Revoke admin</label>';


            if($val->status== 0){
                $action = $approved;
                $status = '<label class="alert alert-warning pending">Pending to approve</label>';
            }elseif($val->status== 1){
                $action = $disapproved;
                $status = '<label class="alert alert-success approved">Approved</label>';
                if($val->user_type == 1){
                    $action = $disapproved.$revoke;
                }else{
                    $action = $disapproved.$admin;
                }
            }
            if($val->active== 0){

                $user_status = '<label class="alert alert-warning offline">Offline</label>';
            }elseif($val->status== 1){

                $user_status = '<label class="alert alert-success online">Online</label>';
            }

            if(Auth::user()->user_type != $val->id){
                $userList[]=['email'=>$val->email,'name'=>$val->name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$action,'status'=>$status,'user_status'=>$user_status];
            }

        }

        return json_encode(['data'=>$userList]);
    }

    public function approveDisapproveUser(Request $request){
        User::where('id',$request->id)->update(['status'=>$request->status]);
    }
    public function approveDisapproveUserAdmin(Request $request){
        User::where('id',$request->id)->update(['user_type'=>$request->status]);
    }
}
