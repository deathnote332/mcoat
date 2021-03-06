<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Theme;
use File;
use PDF;
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

        if($this->isMobile()){
            $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT Users');
            return $theme->scope('users')->render();
        }else{
            $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
            return $theme->scope('users')->render();
        }

    }

    public function getUsers(){
        $users = User::where('is_remove',1)->get();
        $userList = array();
        foreach ($users as $key => $val){
            $approved = '<label id="approve" class="alert alert-info" data-id="'.$val->id.'"  data-approve="1">Change to approve</label>';
            $disapproved = '<label id="approve" class="alert alert-danger" data-id="'.$val->id.'" data-approve="0">Change to disapprove</label>';

            $admin = '<label id="admin" class="alert alert-info" data-id="'.$val->id.'"  data-approve="1">Appoint admin</label>';
            $revoke = '<label id="admin" class="alert alert-danger" data-id="'.$val->id.'" data-approve="2">Revoke admin</label>';

            $delete = "<a><label id='delete' class='alert alert-danger' data-id='$val->id' >Delete</label></a>";


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
                $userList[]=['email'=>$val->email,'name'=>$val->first_name.' '.$val->last_name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$action.$delete,'status'=>$status,'user_status'=>$user_status];
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

    public function employeePage()
    {
        if($this->isMobile()){
            $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT Employees');
            return $theme->scope('employees')->render();
        }else{
            $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT Employees');
            return $theme->scope('employees')->render();
        }

    }


    public function getEmployee(){
        $employee = Employee::get();
        $userList = array();
        foreach ($employee as $key=>$val){
           $employee_data = json_decode($val->record);
            $view = "<a href='biodata/$val->id' target='_blank'><label id='view-receipt' class='alert alert-success' data-id='.$val->id.'>View</label></a>";

            $userList[]=['name'=>$employee_data->first_name.' '.$employee_data->last_name,'position'=>$employee_data->position,'date_hired'=>$employee_data->date_hired,'branch_hired'=>$employee_data->branch_hired,'action'=>$view];
        }

        return json_encode(['data'=>$userList]);
    }

    public function employeeeBiodata(Request $request)
    {

        $employee = Employee::where('user_id',$request->id)->first();
        $data = '';
        if($employee != null){
            $data = $employee->record;
        }

        if($this->isMobile()){
            $theme = Theme::uses('default')->layout('mobile')->setTitle('MCOAT');
            return $theme->scope('biodata',['record'=>$data])->render();
        }else{
            $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
            return $theme->scope('biodata',['record'=>$data])->render();
        }

    }


    public function saveBioData(Request $request){

        $employee = Employee::where('user_id',$request->id)->first();


        $path = 'images';
        if($request->file != ''){
            try {
                $extension = $request->file->getClientOriginalExtension();
                $filename = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
                $new_filename = round(microtime(true)) . '.' . $extension;
                $request->file->move($path, $new_filename);
            } catch (\Exception $ex) {
                $extension = $request->file->getClientOriginalExtension();
                $filename = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $extension;
                $new_filename = round(microtime(true)) . '.' . $extension;
                 $request->file->move($path, $new_filename);
            }
        }else{
            $new_filename = 'mcoat-bg.jpg';
        }


        $record = $request->all();

        $record['img_profile'] = $new_filename;

        User::where('id',Auth::user()->id)->update(['first_name'=>$record['first_name'],'last_name'=>$record['last_name'],'middle_name'=>$record['middle_name']]);

        $data = json_encode($record);

        if($employee != null){
            Employee::insert(['record'=>$data,'user_id'=>Auth::user()->id]);
        }else{

            Employee::where('user_id',Auth::user()->id)->update(['record'=>$data]);

        }


        return $data;
    }

    public function pdfBiodata(Request $request){
        $biodata = Employee::where('user_id',$request->id)->first();
        $pdf = PDF::loadView('pdf.biodata',['data'=>json_decode($biodata->record)])->setPaper('legal')->setWarnings(false);
        return @$pdf->stream();
    }

    public function activityPage(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Activity Logs');
        return $theme->scope('activitylog')->render();
    }


    public function accountSettings(){
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('Account Settings');
        return $theme->scope('resetpassword')->render();
    }
    public  function updateAccount(Request $request){

        User::where('id',Auth::user()->id)->update(['first_name'=>$request->first_name,'last_name'=>$request->last_name,'password'=>Hash::make($request->password)]);
        return 'Account updated successfuly';

    }
}
