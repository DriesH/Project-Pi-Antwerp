<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Database\DatabaseManager;
use DB;
use App\Project;
use App\Categorie;
use App\Phase;
use App\User;
use App\Answer;
use App\Multiple_choice_answer;
use Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Cookie\CookieJar;



class ProjectController extends Controller
{
    public function GetProjects(Request $request){

      Date::setLocale('nl');

        if (isset($request->categorie)) {
          $categorie = $request->categorie;
          /**
          *Array bevat alle projecten en hun data.
          *
          *@var array
          */
          $projecten = DB::table('projects')
                          ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                          ->where('categories.naam', '=', $categorie)
                          ->select('categories.naam as catNaam', 'categories.icon_class', 'projects.*')
                          ->orderBy('projects.created_at', 'desc')
                          ->get();

          $isResetEnabled = true;
        }
        elseif (isset($request->locatie)) {
          $locatie = $request->locatie;
          $projecten = DB::table('projects')
                          ->where('locatie', '=', $locatie)
                          ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                          ->select('categories.naam as catNaam', 'categories.icon_class', 'projects.*')
                          ->orderBy('projects.created_at', 'desc')
                          ->get();
        $isResetEnabled = true;
        }
        else {
          $projecten = DB::table('projects')
                          ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                          ->select('categories.naam as catNaam', 'categories.icon_class', 'projects.*')
                          ->orderBy('projects.created_at', 'desc')
                          ->get();

          $isResetEnabled = false;
        }

        $categories = DB::table('projects')
                    ->where('projects.isActief', '=', 1)
                    ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                    ->select('categories.naam')
                    ->distinct()
                    ->get();

        //duplicates filteren
        $locaties = DB::table('projects')
                    ->where('projects.isActief', '=', 1)
                    ->select('projects.locatie')
                    ->distinct()
                    ->get();



        return view('projecten', [
            'projecten' => $projecten,
            'categories' => $categories,
            'locaties' => $locaties,
            'isResetEnabled' => $isResetEnabled,
        ]);
    }

    public function GetProject($id) {

        /**
        *Array bevat de data van een enkel project.
        *
        *@var $project
        *
        *Array dat de fases bevat.
        *
        *@var $phases
        *
        *
        *
        *@var $projectFollow
        *
        *
        */
        /**
        *Array bevat de data van een enkel project.
        *
        *@var array
        */
        //get project by id
        $project = Project::where('idProject', '=', $id)->first();

        if($project == null || $project->isActief == 0){
          abort(404);
        }
        //get phases of project
        $phases = Phase::where('idProject', '=', $id)->get();
        //get all categories
        $categorien = Categorie::orderBy('idCategorie', 'asc')->get();

        $userId = Auth::id();

        $isFollowing = false;

        $followingProjectsId = DB::table('user_follows')
                            ->select('user_follows.project_id')
                            ->where('user_follows.user_id', '=', $userId)
                            ->get();

        $followingProjectIdArray = array();

        foreach($followingProjectsId as $key => $followingProjectId){
            $followingProjectIdArray[$key] = $followingProjectId->project_id;
        }

        foreach($followingProjectIdArray as $followingProject){
            if($followingProject == $id){
                $isFollowing = true;
            }
        }

        //get questions per phase
        $questions = DB::table('projects')
                    ->join('phases', 'projects.idProject' , '=', 'phases.idProject')
                    ->join('questions', 'phases.idFase', '=', 'questions.idFase')
                    ->where('projects.idProject', '=', $id)
                    ->where('phases.status', '=', 'in-progress')
                    ->select('questions.*')
                    ->get();


        $antwoorden = DB::table('projects')
                    ->join('phases', 'projects.idProject' , '=', 'phases.idProject')
                    ->join('questions', 'phases.idFase', '=', 'questions.idFase')
                    ->join('multiple_choice_answers', 'questions.idVraag', '=', 'multiple_choice_answers.idVraag')
                    ->where('projects.idProject', '=', $id)
                    ->where('phases.status', '=', 'in-progress')
                    ->select('multiple_choice_answers.*')
                    ->get();


        $answeredPhases = DB::table('answers')
                            ->join('questions', 'answers.idVraag', '=', 'questions.idVraag')
                            ->join('phases', 'questions.idFase', '=', 'phases.idFase')
                            ->where('phases.idProject', '=', $id)
                            ->where('idUser', '=', $userId)
                            ->select('phases.idFase')
                            ->distinct()
                            ->get();

        $dataProject = DB::table('phases')
                        ->where( 'phases.idProject' , '=', $id)
                        ->join('questions', 'phases.idFase', '=', 'questions.idFase')
                        ->join('answers', 'questions.idVraag', '=', 'answers.idVraag')
                        ->get();


        $amountAnswered = count($dataProject);

        return view('project', [
            'project' => $project,
            'phases' => $phases,
            'categorien' => $categorien,
            'questions' => $questions,
            'isFollowing' => $isFollowing,
            'antwoorden' => $antwoorden,
            'answeredPhases' => $answeredPhases,
            'amountAnswered' => $amountAnswered

        ]);
    }

    public function PostProject($id, $faseid, Request $request, CookieJar $cookieJar){

      /**
      *Data bevat de values van inputfields van het nieuwe project.
      *
      *@var array
      */
      $data = Input::all();


      if(Auth::user()){
        $user = Auth::user()->id;
      }
      else {
        $user = 0;
        $cookieJar->queue(cookie($faseid, "true", 365 * 24 * 60));

      }


            foreach ($data as $key => $value) {
              if($key != '_token'){
                Answer::create([
                    'idVraag' => $key,
                    'idUser' => $user,
                    'antwoord' => $value
                ]);
              }
            }
      return redirect('/project/' . $id)->with('message', 'Bedankt voor het delen van uw mening! We houden hier zeker rekening mee.');
    }

    public function PostProjectFollow($id, Request $request) {

        $userId = Auth::id();

        $isFollowing = false;

        $followingProjectsId = DB::table('user_follows')
                            ->select('user_follows.project_id')
                            ->where('user_follows.user_id', '=', $userId)
                            ->get();

        $followingProjectIdArray = array();

        foreach($followingProjectsId as $key => $followingProjectId){
            $followingProjectIdArray[$key] = $followingProjectId->project_id;
        }

        foreach($followingProjectIdArray as $followingProject){
            if($followingProject == $id){
                $isFollowing = true;
            }
        }

        if(!$isFollowing){
            DB::table('user_follows')
                ->insert(
                    array('user_id' => $userId, 'project_id' => $id)
                );
        }
        else if($isFollowing){
            DB::table('user_follows')
                ->where('user_id', '=', $userId )
                ->where('project_id', '=', $id)
                ->delete();
        }

        return redirect($request->url());


    }


}
