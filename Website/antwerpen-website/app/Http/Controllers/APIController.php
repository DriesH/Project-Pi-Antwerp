<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

use DB;
use Response;
use File;

use App\Appanswer;


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
                        ->select('categories.naam as catNaam', 'projects.*')
                        ->orderBy('projects.created_at', 'desc')
                        ->get();

        $appvragen = DB::table('appquestions')
                        ->orderBy('appquestions.idProject', 'asc')
                        ->get();

        $projecten_vragen_array = [
            'projecten' => $projecten,
            'appvragen' => $appvragen
        ];

        return Response::json($projecten_vragen_array);

    }

    protected function postAppAntwoorden(Request $request){

      Appanswer::create([
          'answer' => $request['answerUser'],
          'idAppquestions' => $request['questionID'],

      ]);

      $allAnswers = DB::table('appanswers')
                            ->where('appanswers.idAppquestions', '=', $request['questionID'])
                            ->orderBy('appanswers.answer', 'asc')
                            ->get();

      $totalAmountOfAnswers = count($allAnswers);

      $sameAnswers = DB::table('appanswers')
                            ->where('appanswers.idAppquestions', '=', $request['questionID'])
                            ->where('appanswers.answer', '=', $request['answerUser'])
                            ->orderBy('appanswers.answer', 'asc')
                            ->get();
      $totalSameAnswers = count($sameAnswers);

      $percentageSameAnswer = ($totalSameAnswers / $totalAmountOfAnswers) * 100;

      $appanswers_array = [
          'percentageSameAnswer' => $percentageSameAnswer
      ];

      return Response::json($appanswers_array);

    }

}
