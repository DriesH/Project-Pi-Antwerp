<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appquestion extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'question', 'idProject'
  ];
}
