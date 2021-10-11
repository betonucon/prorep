<?php

namespace App\Http\Controllers;
use App\Project;
use App\Projectteam;
use App\User;
use App\Lembur;
use App\Aktifitas;
use Validator;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProgresreportController extends Controller
{
    public function index(request $request){
        $menu='Progres Report';
        
        return view('progresreport.index',compact('menu'));
    }

    public function index_personal(request $request){
        if(Auth::user()['role_id']==1 || Auth::user()['role_id']==2 || Auth::user()['role_id']==3 || Auth::user()['role_id']==5){
            $menu='Progres Report';
        
            return view('progresreport.index_personal',compact('menu'));
        }else{
            return view('error');
        }
        
    }

    public function timeseet(request $request){
        $menu='Absesnsi';
        $data=User::where('username',Auth::user()['username'])->first();
        if($request->periode==''){
            $periode=date('Y-m-d');
        }else{
            $periode=$request->periode;
        }
        $tgl=explode('-',$periode);
        $tahun=$tgl[0];
        $bulan=$tgl[1];
        return view('progresreport.timeseet',compact('menu','data','periode','tahun','bulan'));
        
    }
    public function timeseetdownload(request $request){
        $menu='Absesnsi';
        $data=User::where('username',Auth::user()['username'])->first();
        if($request->periode==''){
            $periode=date('Y-m-d');
        }else{
            $periode=$request->periode;
        }
        $tgl=explode('-',$periode);
        $tahun=$tgl[0];
        $bulan=$tgl[1];
        $data=User::where('username',Auth::user()['username'])->first();
        $pdf = PDF::loadView('progresreport.excel',compact('menu','data','periode','tahun','bulan'));
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream();
        
    }

    public function cari_project_team(request $request){
        $data=Projectteam::where('kode_project',$request->kode_project)->where('username',Auth::user()['username'])->where('progres','<',100)->get();
        echo'<option value="">--Select Job Order Project-----</option>';
        foreach($data as $o){
            echo'<option value="'.$o['id'].'">'.$o['name'].'</option>';
        }
    }

    public function view(request $request){
        $menu='View Progres Report';
        $data=Projectteam::where('id',$request->id)->first();
        if($request->periode==''){
            $periode=bulanberikutnya($data->startdate,$data->enddate,0);
        }else{
            $periode=$request->periode;
        }
        $tgl=explode('-',$periode);
        $tahun=$tgl[0];
        $bulan=$tgl[1];
        $periodemulai=date('mY',strtotime($data->startdate));
        return view('progresreport.view',compact('menu','data','periode','tahun','bulan','periodemulai'));
    }

    public function hapus_lembur(request $request){
        $data=Lembur::where('id',$request->id)->delete();
    }

    public function personal_view(request $request){
        $menu='Activitas Personal';
        $data=User::where('username',$request->username)->first();
        if($request->periode==''){
            $periode=date('Y-m-d');
        }else{
            $periode=$request->periode;
        }
        $tgl=explode('-',$periode);
        $tahun=$tgl[0];
        $bulan=$tgl[1];
        return view('progresreport.personal_view',compact('menu','data','periode','tahun','bulan'));
    }

    public function view_project(request $request){
        $data=Projectteam::where('username',$request->username)->get();
        echo'
        <div class="widget-chart-info">
            <h4 class="widget-chart-info-title">Task progress project</h4>
            <p class="widget-chart-info-desc">List Project Personal.</p>';
            if(count_progres_bar_project_personal($request->username)>0){
                foreach($data as $x=>$o){
                    if(progres_bar_project_personal($o['kode_project'],$request->username)==100){
                        $color='bg-indigo';
                    }else{
                        if(progres_bar_project_personal($o['kode_project'],$request->username)>50){
                            if(progres_bar_project_personal($o['kode_project'],$request->username)>70){
                                $color='bg-indigo';
                            }else{
                                $color='bg-yellow';
                            }
                            
                        }else{
                            $color='bg-red';
                        }
                    }
                    echo'
                        <div class="widget-chart-info-progress">
                            <b>'.$o->project['name'].'aaa</b>
                            <span class="pull-right">'.progres_bar_project_personal($o['kode_project'],$request->username).'%</span>
                        </div>
                        <div class="progress progress-sm m-b-15">
                            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-corner '.$color.'" style="width: '.progres_bar_project_personal($o['kode_project'],$request->username).'%"></div>
                        </div>
                    ';
                }
            }else{
                echo'

                <div  style="background:#fff;border:dotted 1px #000;height:30px;font-size:15px;text-align:center">
                    Null Project
                </div>
                ';
            }
            echo'            
        </div>


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

            if($data){
                $progresteam=Projectteam::where('id',$request->project_team_id)->update([
                    'prosesdate'=>date('Y-m-d'),
                    'progres'=>$request->progres,
                ]);
                echo'ok';
            }

            
        }
    }

    public function overtime(request $request){
        error_reporting(0);
        
        $rules = [
            'keterangan'=> 'required',
            'tanggal'=> 'required|date',
            'mulai'=> 'required|date_format:H:i',
            'sampai'=> 'required|date_format:H:i',
            'project_team_id'=> 'required|numeric',
            'progres'=> 'required|numeric',
            
            
        ];

        $messages = [
            'keterangan.required'=> 'Insert Activitas', 
            'tanggal.required'=> 'Insert Date', 
            'mulai.required'=> 'Insert Start Time', 
            'sampai.required'=> 'Insert Enda Time', 
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
            
            $data= Lembur::create([
                'kode_project'=>$request->kode_project,
                'project_team_id'=>$request->project_team_id,
                'keterangan'=>$request->keterangan,
                'progres'=>$request->progres,
                'tanggal'=>$request->tanggal,
                'mulai'=>$request->tanggal.' '.$request->mulai,
                'sampai'=>$request->tanggal.' '.$request->sampai,
                'username'=>Auth::user()['username'],
            ]);

            if($data){
                $progresteam=Projectteam::where('id',$request->project_team_id)->update([
                    'prosesdate'=>date('Y-m-d'),
                    'progres'=>$request->progres,
                ]);
                echo'ok';
            }

            
        }
    }
    
}
