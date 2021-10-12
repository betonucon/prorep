<?php

function name(){
    return 'PROREP (Progres Report)';
}
function company(){
    return 'PT KRAKATAU INFROMATION TECHNOLOGY';
}

function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}
function warna($bulan)
{
   Switch ($bulan){
      case '0' : $bulan="Yellow";
         Break;
      case 1 : $bulan="#F0F8FF";
         Break;
      case 2 : $bulan="#FAEBD7";
         Break;
      case 3 : $bulan="#00FFFF";
         Break;
      case 4 : $bulan="#7FFFD4";
         Break;
      case 5 : $bulan="#F0FFFF";
         Break;
      case 6 : $bulan="#8A2BE2";
         Break;
      case 7 : $bulan="#A52A2A";
         Break;
      case 8 : $bulan="#DEB887";
         Break;
      case 9 : $bulan="#5F9EA0";
         Break;
      case 10 : $bulan="#7FFF00";
         Break;
      case 11 : $bulan="#D2691E";
         Break;
      case 12 : $bulan="#FF7F50";
         Break;
      }
   return $bulan;
}

function hari_ini($tgl){
    $hari=date('D',strtotime($tgl));
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
 
}

function selisih_jam($tgl1,$tgl2){
    $waktu_awal        =strtotime($tgl1);
    $waktu_akhir    =strtotime($tgl2); 
    $diff    =$waktu_akhir - $waktu_awal;
    $jam    =floor($diff / (60 * 60));
    $menit    =$diff - $jam * (60 * 60);
    $selisih=$jam.'.'.$menit;
    return $selisih;
}

function tgl_indo($id){
    $exp=explode('-',$id);
    $data=$exp[2].' '.bulan($exp[1]).' '.$exp[0];
    return $data;
}

function ubah_bulan($id){
    if($id>9){
       $data=$id;
    }else{
       $data='0'.$id;
    }
    return $data;
 }
function ubah_jam($id){
    return date('H:i',strtotime($id));
 }

function dashboard_project_count(){
    if(Auth::user()['role_id']==1 || Auth::user()['role_id']==5){
        $data=App\Project::count();
    }
    if(Auth::user()['role_id']==2 || Auth::user()['role_id']==3){
        $data=App\Project::where('costcenter_id',Auth::user()['costcenter_id'])->count();
    }
    return $data;
}

function project_count(){
    $data=App\Project::where('username',Auth::user()['username'])->count();
    return $data;
}

function kategori_get(){
    $data=App\Kategori::all();
    return $data;
}

function progres_get(){
    $data=App\Progres::all();
    return $data;
}

function joborder_get($id){
    $data=App\Joborder::where('kategori_id',$id)->get();
    return $data;
}

function cek_aktifitas($id,$tgl){
    $data=App\Aktifitas::where('project_team_id',$id)->where('tanggal',$tgl)->count();
    return $data;
}
function get_aktifitas($id,$tgl){
    $data=App\Aktifitas::where('project_team_id',$id)->where('tanggal',$tgl)->orderBy('id','Asc')->get();
    return $data;
}
function cek_aktifitas_personal($username,$tgl){
    $data=App\Aktifitas::where('username',$username)->where('tanggal',$tgl)->count();
    return $data;
}
function aktifitas($id,$tgl){
    $data=App\Aktifitas::where('project_team_id',$id)->where('tanggal',$tgl)->first();
    return $data['keterangan'];
}
function aktifitas_personal($username,$tgl){
    $data=App\Aktifitas::where('username',$username)->where('tanggal',$tgl)->get();
    return $data;
}
function progres_aktifitas($id,$tgl){
    $data=App\Aktifitas::where('project_team_id',$id)->where('tanggal',$tgl)->first();
    return $data['progres'];
}

function dashboard_project_get($cos){
    if(Auth::user()['role_id']==1 || Auth::user()['role_id']==5){
        $data=App\Project::where('costcenter_id',$cos)->get();
    }
    if(Auth::user()['role_id']==2 || Auth::user()['role_id']==3){
        $data=App\Project::where('costcenter_id',$cos)->get();
    }
    if(Auth::user()['role_id']==4){
        $data=App\Projectteam::where('username',Auth::user()['username'])->orderBy('kode_project','Asc')->get();
    }
    
    
    return $data;
}
function project_get(){
    
    $data=App\Project::where('username',Auth::user()['username'])->get();
    
    return $data;
}


function user_get(){
    if(Auth::user()['role_id']==1 || Auth::user()['role_id']==5){
        $data=App\User::orderBy('name','Asc')->get();
    }
    if(Auth::user()['role_id']==2 || Auth::user()['role_id']==3){
        $data=App\User::where('costcenter_id',Auth::user()['costcenter_id'])->orderBy('name','Asc')->get();
    }
    
    
    return $data;
}

function user_personal_get(){
    if(Auth::user()['role_id']==1 || Auth::user()['role_id']==5){
        $data=App\User::orderBy('name','Asc')->get();
    }
    if(Auth::user()['role_id']==2 || Auth::user()['role_id']==3){
        $data=App\User::where('costcenter_id',Auth::user()['costcenter_id'])->orderBy('name','Asc')->get();
    }
    
    return $data;
}

function role_get(){
    $data=App\Role::orderBy('name','Asc')->get();
    return $data;
}

function progres_bar_project_lama($kodeproject){
    
    $data=App\Projectteam::where('kode_project',$kodeproject)->count();
    if($data>0){
        $get=App\Projectteam::where('kode_project',$kodeproject)->get();
        $jumlah=0;
        foreach($get as $o){
            $cek=App\Aktifitas::where('project_team_id',$o['id'])->count();
            if($cek>0){
                $team=App\Aktifitas::where('project_team_id',$o['id'])->orderBy('id','Desc')->firstOrfail();
                $jumlah+=$team['progres'];
            }else{
                $jumlah+=0;
            }
            
        }
        $progres=($jumlah/$data);
    }else{
        $progres=0;
    }
    return round($progres);
}
function progres_bar_project($kodeproject){
    error_reporting(0);
    $data=App\Projectteam::where('kode_project',$kodeproject)->count();
    if($data>0){
        $sum=App\Projectteam::where('kode_project',$kodeproject)->sum('progres');
        $progres=($sum/$data);
    }else{
        $progres='0';
    }
    
    return round($progres);
}
function progres_bar_project_personal($kodeproject,$username){
    error_reporting(0);
    $data=App\Projectteam::where('kode_project',$kodeproject)->where('username',$username)->count();
    if($data>0){
        $sum=App\Projectteam::where('kode_project',$kodeproject)->where('username',$username)->sum('progres');
        $progres=($sum/$data);
    }else{
        $progres='0';
    }
    
    return round($progres);
}
function count_progres_bar_project_personal($username){
    error_reporting(0);
    $data=App\Projectteam::where('username',$username)->count();
    
    return $data;
}

function periode($tgl){
    $data=date('F Y',strtotime($tgl));
    return $data;
}

function kalender($tanggal){
    $exp=explode('-',$tanggal);
    $tahun = $exp[0];
    $bulan = $exp[1]; 
    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
    return $tanggal;
}

function selisih_bulan($tanggal,$tanggal2){
    $timeStart = strtotime($tanggal);
    $timeEnd = strtotime($tanggal2);
    $numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
    $numBulan += date("m",$timeEnd)-date("m",$timeStart);
    return $numBulan;
}
function bulanberikutnya($tanggal,$tanggal2,$waktu){
    error_reporting(0);
    $exp=explode('-',$tanggal);
    $exp2=explode('-',$tanggal2);
    $tgl=$exp[0].'-'.$exp[1].'-'.$exp2[2];
    $bulan = date('Y-m-d', strtotime('+'.$waktu.' month', strtotime($tgl)));
    return $bulan;
 }

function progresreport_get(){
    $data=App\Projectteam::select('kode_project')->where('username',Auth::user()['username'])->groupBy('kode_project')->get();
    return $data;
}

function lemburreport_get($username,$tgl){
    $data=App\Lembur::where('username',$username)->where('tanggal',$tgl)->get();
    return $data;
}
function progresreport_count(){
    $data=App\Projectteam::select('kode_project')->where('username',Auth::user()['username'])->groupBy('kode_project')->count();
    return $data;
}
function progresreport_count_order($kode_project){
    $data=App\Projectteam::where('kode_project',$kode_project)->where('username',Auth::user()['username'])->count();
    return $data;
}
function Total_progresreport_count($kode_project){
    $data=App\Projectteam::where('kode_project',$kode_project)->where('username',Auth::user()['username'])->sum('progres');
    $sum=$data/progresreport_count_order($kode_project);
    return round($sum);
}

function projectteam_get($kode){
    $data=App\Projectteam::where('kode_project',$kode)->where('sts',0)->get();
    return $data;
}
function projectteamsolve_get($kode){
    $data=App\Projectteam::where('kode_project',$kode)->where('sts',1)->get();
    return $data;
}
function orderproject_get($username,$kode){
    $data=App\Projectteam::where('kode_project',$kode)->where('username',$username)->get();
    return $data;
}

function user_gate(){
    $data=App\User::orderBy('name','Asc')->get();
    return $data;
}

function jml_minggu(){
    error_reporting(0);
    $detik = 24 * 3600;
    $tgl_awal = strtotime('2021-10-08');
    $tgl_akhir = strtotime('2021-10-30');
    
    $minggu = 0;
    for ($i=$tgl_awal; $i < $tgl_akhir; $i += $detik)
    {
        if (date("w", $i) == "0"){
            $minggu++;
        }
    }
    return $minggu;
    
}

function costcenter_get(){
    $data=App\Costcenter::orderBy('name','Asc')->get();
    return $data;
}

function parsing_validator($url){
    $content=utf8_encode($url);
    $data = json_decode($content,true);
 
    return $data;
 }




?>