<?php

namespace App\Http\Controllers;
use App\User;
use App\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class MasterController extends Controller
{
    public function profilhp(request $request){
        if (trim($request->no_hp) == '') {$error[] = '<p>- Masukan Nomor HP terlebih dahulu</p>';}
        if (isset($error)) {echo '<b>Error</b>: <br />'.implode('<br />', $error);} 
        else{
            $data           = User::where('id',Auth::user()['id'])->update(
                ['no_hp'=>$request->no_hp]
            );
            
            if($data){
                echo'ok';
            }
        }
    }

    public function sosmed(request $request){
        if (trim($request->twiter) == '') {$error[] = '<p>- Masukan Link Twiter terlebih dahulu</p>';}
        if (trim($request->facebook) == '') {$error[] = '<p>- Masukan Link Facebook terlebih dahulu</p>';}
        if (trim($request->instagram) == '') {$error[] = '<p>- Masukan Link Instagram terlebih dahulu</p>';}
        if (isset($error)) {echo '<b>Error</b>: <br />'.implode('', $error);} 
        else{
            $data           = Karyawan::where('nik',Auth::user()['username'])->update(
                [
                    'twiter'=>$request->twiter,
                    'facebook'=>$request->facebook,
                    'instagram'=>$request->instagram,
                ]
            );
            
            if($data){
                echo'ok';
            }
        }
    }


    public function profilfoto(request $request){
        error_reporting(0);

        if (trim($request->foto) == '') {$error[] = '<p>- Upload foto terlebih dahulu</p>';}
        if (isset($error)) {echo '<b>Error</b>: <br />'.implode('<br />', $error);} 
        else{
            $cek=explode('/',$_FILES['foto']['type']);
            $file_tmp=$_FILES['foto']['tmp_name'];
            $file=explode('.',$_FILES['foto']['name']);
            $filename=Auth::user()['username'].date('his').'.'.$cek[1];
            $lokasi='foto/';
            
            if($cek[0]=='image'){
                if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                    $data           = Karyawan::where('nik',Auth::user()['username'])->update(
                        ['foto'=>$filename]
                    );
                    
                    if($data){
                        echo'ok';
                    }

                }else{
                    echo '<b>Error</b>: <br />Gagal Update';
                }
            }
            
        }
    }
}
