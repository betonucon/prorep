<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectteam extends Model
{
    protected $table = 'project_team';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'username',
        'kode_project',
        'startdate',
        'enddate',
        'progres',
        'prosesdate',
        'sts',
        'job_order_id',
        
    ];
    function user(){
      return $this->belongsTo('App\User','username','username');
    }
    function project(){
		  return $this->belongsTo('App\Project','kode_project','kode_project');
    }
    function joborder(){
		  return $this->belongsTo('App\Joborder','job_order_id','id');
    }
}
