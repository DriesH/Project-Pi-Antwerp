<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'vraag', 'soort_vraag', 'idFase'
  ];

    public function phases(){
        return $this->hasOne('App\Phase', 'idFase', 'idFase');
    }
}
