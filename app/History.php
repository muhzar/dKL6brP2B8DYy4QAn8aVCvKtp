<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class History extends Model
{

    protected $table = 'history';
    protected $fillable = [
        'guard_id', 'cluster_id', 'shift_id', 'date'
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
        return $this->belongsTo('App\Cluster', 'cluster_id', 'code');
    }


}
