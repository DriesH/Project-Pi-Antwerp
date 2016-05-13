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
use Auth;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller
{
    public function GetProjects(){
        /**
        *Array bevat alle projecten en hun data.
        *
        *@var array
        */
        $projecten = DB::table('projects')
                        ->join('categories', 'projects.idCategorie', '=', 'categories.idCategorie')
                        ->select('categories.naam as catNaam', 'categories.icon_class', 'projects.*')
                        ->orderBy('projects.created_at', 'desc')
                        ->get();

        $categories = Categorie::all();

        //duplicates filteren
        $locaties = array_unique(DB::table('projects')
                    ->select('projects.locatie')
                    ->get(), SORT_REGULAR);



        return view('projecten', [
            'projecten' => $projecten,
            'categories' => $categories,
            'locaties' => $locaties,
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
                    ->select('questions.*')
                    ->get();


        return view('project', [
            'project' => $project,
            'phases' => $phases,
            'categorien' => $categorien,
            'questions' => $questions,
            'isFollowing' => $isFollowing,
        ]);

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
