<?php

namespace App\Http\Controllers;
use App\Project;
use App\Projectteam;
use App\User;
use App\Aktifitas;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class OtorisasiController extends Controller
{
    public function index(request $request){
        if(Auth::user()['role_id']==1 || Auth::user()['role_id']==2 || Auth::user()['role_id']==3 || Auth::user()['role_id']==5){
            $menu='Otorisasi';
            
            return view('otorisasi.index',compact('menu'));
        }else{
            return view('error');
        }
    }

    public function ubah(request $request){
        $data=User::where('username',$request->username)->first();
        echo'
            <div class="col-xl-10 offset-xl-1">
                <div class="form-group row m-b-10">
                    <label class="col-lg-3 text-lg-right col-form-label"><b>User</b></label>
                    <div class="col-lg-9 col-xl-3" style="padding-right: 0px;">
                        <input type="text"  value="'.$data['username'].'" disabled placeholder="Enter....." class="form-control">
                    </div>
                    <div class="col-lg-9 col-xl-6" style="padding-left: 3px;">
                        <input type="text"  value="'.$data['name'].'" disabled  placeholder="Enter....." class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-xl-10 offset-xl-1">
                <div class="form-group row m-b-10">
                    <label class="col-lg-3 text-lg-right col-form-label"><b>CostCenter</b></label>
                    <div class="col-lg-9 col-xl-9">
                        <select  name="costcenter_id" placeholder="Enter....." class="form-control">
                            <option value="">--Select-----</option>';
                            foreach(costcenter_get() as $costcenter_get){
                                if($data['costcenter_id']==$costcenter_get->id){$sel='selected';}else{$sel='';}
                                echo'<option value="'.$costcenter_get->id.'" '.$sel.'>-'.$costcenter_get->name.'</option>';
                            }
                            echo'
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 offset-xl-1">
                <div class="form-group row m-b-10">
                    <label class="col-lg-3 text-lg-right col-form-label"><b>Otorisasi</b></label>
                    <div class="col-lg-9 col-xl-9">
                        <select  name="role_id" placeholder="Enter....." class="form-control">
                            <option value="">--Select-----</option>';
                            foreach(role_get() as $role_get){
                                if($data['role_id']==$role_get->id){$sel='selected';}else{$sel='';}
                                echo'<option value="'.$role_get->id.'" '.$sel.'>-'.$role_get->name.'</option>';
                            }
                            echo'
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="username" value="'.$data['username'].'">
        ';
    }

    public function save(request $request){
        error_reporting(0);
        
        $rules = [
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
            'project_team_id'=> 'required|numeric',
            'progres'=> 'required|numeric',
            
        ];

        $messages = [
            'keterangan.required'=> 'Insert Activitas', 
            'progres.required'=> 'Insert Progres Activitas',  
            'progres.numeric'=> 'Insert Progres Activitas',    
            'progres.max'=> 'Insert MAX Activitas',    
            
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
            $proj=Projectteam::find($request->project_team_id);
            $data= Aktifitas::create([
                'kode_project'=>$proj['kode_project'],
                'project_team_id'=>$request->project_team_id,
                'keterangan'=>$request->keterangan,
                'progres'=>$request->progres,
                'tanggal'=>$request->tanggal,
                'username'=>Auth::user()['username'],
            ]);

            echo'ok';
        }
    }

    public function update(request $request){
        error_reporting(0);
        
        $rules = [
            'costcenter_id'=> 'required|numeric',
            'role_id'=> 'required|numeric',
            
            
        ];

        $messages = [
            'costcenter_id.required'=> 'Select Costcenter', 
            'costcenter_id.numeric'=> 'Select Costcenter numeric',  
            'role_id.required'=> 'Select Otorisasi',      
            'role_id.numeric'=> 'Select Otorisasi numeric',      
            
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
            $data= User::where('username',$request->username)->update([
                'costcenter_id'=>$request->costcenter_id,
                'role_id'=>$request->role_id,
            ]);

            echo'ok';
        }
    }
    
}
