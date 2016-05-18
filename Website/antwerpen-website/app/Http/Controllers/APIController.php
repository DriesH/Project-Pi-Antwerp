<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Response;

class APIController extends Controller
{
  public function __construct(){
      //middleware voor API met key/token???
  }



  protected function getProjecten(){

      /**
      *projecten een array van alle projecten uit de db.
      *
      *@var array
      */
      $projecten = DB::table('projects')
                      ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                      ->select('categories.naam as catNaam', 'categories.icon_class', 'projects.*')
                      ->orderBy('projects.created_at', 'desc')
                      ->get();

      return Response::json($projecten);

  }

}
