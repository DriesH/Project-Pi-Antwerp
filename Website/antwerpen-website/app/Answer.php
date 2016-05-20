<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'antwoord', 'idUser', 'idVraag',
  ];
}
