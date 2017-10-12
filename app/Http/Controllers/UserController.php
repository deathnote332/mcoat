<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                $userList[]=['email'=>$val->email,'name'=>$val->first_name.' '.$val->last_name,'created_at'=>date('M d,Y',strtotime($val->created_at)),'action'=>$action,'status'=>$status,'user_status'=>$user_status];
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
//
//        <th>Name</th>
//                    <th>Position</th>
//                    <th>Date Hired</th>
//                    <th>Branch Hired</th>
//                    <th>Action</th>
        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('employees')->render();
    }


    public function getEmployee(){
        $employee = Employee::get();
        $userList = array();
        foreach ($employee as $key=>$val){
           $employee_data = json_decode($val->record);
            $action = '<label id="approve" class="alert alert-info" data-id="'.$val->id.'" >View</label>';

            $userList[]=['name'=>$employee_data->first_name.' '.$employee_data->last_name,'position'=>$employee_data->position,'date_hired'=>$employee_data->date_hired,'branch_hired'=>$employee_data->branch_hired,'action'=>$action];
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

        $theme = Theme::uses('default')->layout('defaultadmin')->setTitle('MCOAT');
        return $theme->scope('biodata',['record'=>$data])->render();
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
        $child = [
          'first_name' => json_decode($biodata->record)->child_first_name,
          'last_name' => json_decode($biodata->record)->child_last_name,
          'age' => json_decode($biodata->record)->child_age,
        ];
        $child1 = [
            'first_name' => json_decode($biodata->record)->child_first_name_1,
            'last_name' => json_decode($biodata->record)->child_last_name_1,
            'age' => json_decode($biodata->record)->child_age_1,
        ];
        $pdf = PDF::loadView('pdf.biodata',['data'=>json_decode($biodata->record),'child'=>$child,'child_1'=>$child1])->setPaper('legal')->setWarnings(false);
        return @$pdf->stream();
    }
}
