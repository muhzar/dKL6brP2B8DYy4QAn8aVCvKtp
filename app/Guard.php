<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Guard extends Model
{

    protected $table = 'guards';
    protected $fillable = [
        'name', 'username', 'password'
    ];

}
