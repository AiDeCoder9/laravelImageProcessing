<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $guarded=[];


    public function file(){
        return $this->belongsTo(User::class);
    }
}
