<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    
    public $timestamps = false;
    
    public function questions(){
        return $this->hasMany('App\Question', 'idFase', 'idFase');
    }
    
}
