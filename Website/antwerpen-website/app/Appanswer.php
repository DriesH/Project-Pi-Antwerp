<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appanswer extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'answer', 'idAppquestions'
  ];
}
