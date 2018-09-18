<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Track extends Model
{

    protected $table = 'tracks';
    protected $fillable = [
        'name', 'code', 'cluster_code'
    ];


    public function getCluster() {
        return $this->belongsTo('App\Cluster', 'cluster_code', 'code');
    }

    
}
