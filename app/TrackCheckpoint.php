<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class TrackCheckpoint extends Model
{

    protected $table = 'track_checkpoint';
    protected $fillable = [
        'checkpoint_code', 'track_code', 'latitude', 'longitude', 'point_order', 'description', 'beacon_id'
    ];

    
}
