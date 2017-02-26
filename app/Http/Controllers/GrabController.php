<?php
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 2/22/2017
 * Time: 8:19 AM
 */

namespace App\Http\Controllers;


use App\User;
use App\Util\Helper;

class GrabController extends Controller
{

    public function __construct(){
        $this->user = new User();
        $this->job = new Job();
        $this->admin = new Admin();
    }

    public function postRegisterUser(){

        $this->user = Input::all();

//        $this->user = [
//            'name'=> $data['name'],
//            'email'=> $data['email'],
//            'phone'=> $data['phone'],
//            'address'=> $data['address'],
//            'cp_name'=> $data['cp_name'],
//            'cp_address'=> $data['cp_address'],
//            'cp_phone'=> $data['cp_phone'],
//            'token'=> $data['token']
//        ];

        $user = User::where('email',$this->user['email'])->first();

        if($user){
            $user->update($this->user);
        }else{
            User::insert($this->user);
        }

        return json_encode(array('success'=>1));
    }


    public function postSubmitJob(){

        $this->job  = Input::all();
        $this->job['status']  = 0;

        $admin = Admin::where('job_id',$this->job['job_id']->first());

//        $this->job = [
//            'name'=> $data['name'],
//            'address'=> $data['address'],
//            'long'=> $data['long'],
//            'lat'=> $data['lat'],
//            'job_id'=> $data['job_id'],
//            'status'=> 0,
//        ];


        if(Job::insert($this->job)){
            Helper::sendNotification($admin['token']);
            return json_encode(array('success'=>1,'id'=>$this->job->id));
        }else{
            return json_encode(array('success'=>0));
        }

    }

    public function postLoginAdmin(){

        $this->admin = Input::all();
        $admin = Admin::where('email', $this->admin)->first();
        $data = [
            'name'=>$admin['name'],
            'email'=>$admin['email'],
            'phone'=>$admin['phone'],
            'address'=>$admin['address'],
            'institution_name'=>$admin['institution_name    '],
            'job_id'=>$admin['job_id'],
        ];

        if($admin){
            if(Hash::check($this->admin['password'], $admin->password)){
                return json_encode(array('success'=>1, 'admin'=>$data));
            }else{
                return json_encode(array('success'=>0, 'msg'=>'Incorrect password.'));
            }
        }else{
            return json_encode(array('success'=>0, 'msg'=>'Email does not exist.'));
        }

    }
    public function getJobs($job_id){
        $this->job = Job::where('job_id', $job_id)->where('status',0)->get();
        $user = User::find($this->job['user_id']);

        $data = [
            'id'=>$this->job['id'],
            'cp_name'=>$user['cp_name'],
            'cp_address'=>$user['cp_address'],
            'cp_phone'=>$user['cp_phone'],
            'address'=>$this->job['address'],
            'long'=>$this->job['long'],
            'lat'=>$this->job['lat'],
            'job_id'=>$this->job['job_id'],
            'status'=>$this->job['status']
        ];

        return json_encode(array('success'=>1, 'job'=>$data));
    }

    public function getAcceptJob($id){

        $this->job = Job::find($id);
        $this->job['status'] = 1;

        $user = $this->job['user_id'];
        Helper::sendNotification($user['token_id']);

        $this->job->save;
        return json_encode(array('success'=>1));
    }

    public function getJobStatus($id){
        $this->job = Job::find($id);
        return json_encode(array('success'=>1, 'status'=>$this->job['status']));
    }

    public function getFinishJob($id){

        $this->job = Job::find($id);
        $this->job['status'] = 2;

        $user = $this->job['user_id'];
        Helper::sendNotification($user['token_id']);

        $this->job->save;
        return json_encode(array('success'=>1));
    }

}