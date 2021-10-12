<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'sts',
        'username',
        'kode_project',
        'startdate',
        'enddate',
        'costcenter_id',
        'kategori_id',
        'createdate',
    ];

    

    function user(){
		  return $this->belongsTo('App\User','username','username');
    }
    function costcenter(){
		  return $this->belongsTo('App\Costcenter','costcenter_id','id');
    }
    function kategori(){
        return $this->belongsTo('App\Kategori','kategori_id','id');
    }
}
