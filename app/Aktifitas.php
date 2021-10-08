<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    protected $table = 'aktifitas';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kode_project',
        'project_team_id',
        'keterangan',
        'progres',
        'tanggal',
        'username',
        'sts',

    ];

    function project(){
        return $this->belongsTo('App\Project','kode_project','kode_project');
  }
}
