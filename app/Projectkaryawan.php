<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectkaryawan extends Model
{
    protected $table = 'project_team';
    public $timestamps = false;

    function project(){
      return $this->belongsTo('App\Project','kode_project','kode_project');
    }
    function karyawan(){
      return $this->belongsTo('App\Karyawan','nik','nik');
    }
}
