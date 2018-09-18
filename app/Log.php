<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $table = 'user_log';
    protected $fillable = [
        'user_id', 'command', 'description'
    ];

}
