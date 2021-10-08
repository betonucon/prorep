<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    protected $table = 'lembur';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode_project',
        'project_team_id',
        'keterangan',
        'progres',
        'tanggal',
        'mulai',
        'sampai',
        'username',

    ];

    function project(){
        return $this->belongsTo('App\Project','kode_project','kode_project');
  }
}
