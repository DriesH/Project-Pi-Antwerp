<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

use DB;
use Response;
use File;


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
                        ->join('appquestions', 'projects.idProject', '=', 'appquestions.idProject')
                        ->select('categories.naam as catNaam', 'projects.*', 'appquestions.*')
                        ->orderBy('projects.created_at', 'desc')
                        ->get();

        $projecten_array = [
            'projecten' => $projecten
        ];

        return Response::json($projecten_array);

    }

    protected function postAppAntwoorden(Request $request){



      File::put('testlog.txt', $request['projectID']);
      File::append('testlog.txt', $request['questionID']);
      File::append('testlog.txt', $request['answerUser']);


    }

}
