<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class GuardCluster extends Model
{

    protected $table = 'guard_cluster';
    protected $fillable = [
        'cluster_id', 'guard_id'
    ];


    public function guards() {
        return $this->belongsTo('App\Guard', 'guard_id', 'id');
    }

    public function cluster() {
        return $this->belongsTo('App\Cluster', 'cluster_id', 'id');
    }

    public function scopeSearch($query, $keyword) {
        $guardId = Guard::select('id')->where('name', 'iLIKE', "%$keyword%")->get()->toArray();
        $clusterId = Cluster::select('id')->where('name', 'iLIKE', "%$keyword%")->get()->toArray();
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword, $guardId, $clusterId) {
                $query->whereIn("guard_id", $guardId)
                ->orWhereIn("cluster_id", $clusterId);
            });
        }
        return $query;
    }
    
}
