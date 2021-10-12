<?php

namespace App\Http\Controllers;
use App\Project;
use App\Projectteam;
use App\Karyawan;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProjectController extends Controller
{
    public function index(request $request){
        $menu='Project (Project Manager)';
        
        return view('project.index',compact('menu'));
    }
    public function view(request $request){
        $menu='View Project';
        $data=Project::where('kode_project',$request->kode)->first();
        return view('project.view',compact('menu','data'));
    }
    
    
    public function save(request $request){
        error_reporting(0);
        
        $rules = [
            'name'=> 'required',
            'costcenter_id'=> 'required|numeric',
            'kategori_id'=> 'required|numeric',
            'startdate'=> 'required|date',
            'enddate'=> 'required|date',
        ];

        $messages = [
            'name.required'=> 'Insert Project Name', 
            'costcenter_id.required'=> 'Selected Costcenter', 
            'kategori_id.required'=> 'Selected Categori Project', 
            'startdate.required'=> 'Insert Startdate Project',  
            'enddate.required'=> 'Insert Enddate Project',  
            
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            
            foreach(parsing_validator($val) as $value){
                foreach($value as $isi){
                    echo'-&nbsp;'.$isi.'<br>';
                }
            }
        }else{
            $data= Project::create([
                'name'=>$request->name,
                'sts'=>1,
                'username'=>Auth::user()['username'],
                'kode_project'=>'IN'.Auth::user()['username'].date('ymdhis'),
                'startdate'=>$request->startdate,
                'kategori_id'=>$request->kategori_id,
                'enddate'=>$request->enddate,
                'costcenter_id'=>$request->costcenter_id,
                'createdate'=>date('Y-m-d'),
            ]);

            echo'ok';
        }
    }

    public function solve(request $request){
        $data= Projectteam::where('id',$request->id)->update([
            'sts'=>1,
        ]);
    }

    public function save_team(request $request){
        error_reporting(0);
        
        $rules = [
            'username'=> 'required',
            'job_order_id'=> 'required|numeric',
            'name'=> 'required',
            'startdate'=> 'required|date',
            'enddate'=> 'required|date',
        ];

        $messages = [
            'username.required'=> 'Selected Team', 
            'job_order_id.required'=> 'Select Job order',  
            'job_order_id.numeric'=> 'Select Job order',    
            'name.required'=> 'Insert Job Order', 
            'startdate.required'=> 'Insert Startdate Project',  
            'enddate.required'=> 'Insert Enddate Project', 
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            
            foreach(parsing_validator($val) as $value){
                foreach($value as $isi){
                    echo'-&nbsp;'.$isi.'<br>';
                }
            }
        }else{
            $data= Projectteam::create([
                'name'=>$request->name,
                'username'=>$request->username,
                'kode_project'=>$request->kode_project,
                'job_order_id'=>$request->job_order_id,
                'startdate'=>$request->startdate,
                'enddate'=>$request->enddate,
                'progres'=>'0',
                'sts'=>'0',
            ]);

            echo'ok';
        }
    }
    
    public function update(request $request){
        error_reporting(0);

        if (trim($request->kode_project) == '') {$error[] = '<p>- Masukan Kode Project terlebih dahulu</p>';}
        if (trim($request->name) == '') {$error[] = '<p>- Masukan Nama Project terlebih dahulu</p>';}
        if (trim($request->startdate) == '') {$error[] = '<p>- Masukan Start Date terlebih dahulu</p>';}
        if (trim($request->enddate) == '') {$error[] = '<p>- Masukan End Date terlebih dahulu</p>';}
        if (isset($error)) {echo '<b>Error</b>: <br />'.implode('<br />', $error);} 
        else{
            
            
                $data               = Project::find($request->id);
                $data->kode_project = $request->kode_project;
                $data->startdate = $request->startdate;
                $data->enddate = $request->enddate;
                $data->name         = $request->name;
                $data->save();

                echo 'ok@'.encode($data['kode_project']);
            
            
        }
    }

    
}
