<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rolenya extends Model
{
    protected $table = 'rolenya';
    public $timestamps = false;

    function role(){
      return $this->belongsTo('App\Role','role','id');
    }
    function karyawan(){
      return $this->belongsTo('App\Karyawan','nik','nik');
    }
}
