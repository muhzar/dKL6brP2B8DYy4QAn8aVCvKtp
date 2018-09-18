<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Live extends Model
{

    protected $table = 'temp';
    protected $fillable = [
        'cluster', 'longitude', 'latitude', 'unique_key', 'accuracy', 'speed'
    ];

    
}
