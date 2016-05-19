<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multiple_choice_answer extends Model
{
  public $timestamps = false;

  protected $fillable = [
      'antwoord_1', 'antwoord_2', 'antwoord_3', 'antwoord_4', 'idVraag'
  ];
}
