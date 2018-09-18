<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Patrol extends Model
{

    protected $table = 'patrols';
    protected $fillable = [
        'guard_id', 'cluster_code', 'shift_id'
    ];


    public function getGuard() {
        return $this->belongsTo('App\Guard', 'guard_id', 'username');
    }

    public function getShift() {
        return $this->belongsTo('App\Shift', 'shift_id', 'id');
    }

    public function getTrack() {
        return $this->belongsTo('App\Track', 'track_code', 'code');
    }

    public function getCluster() {
        return $this->belongsTo('App\Cluster', 'cluster_code', 'code');
    }

}
