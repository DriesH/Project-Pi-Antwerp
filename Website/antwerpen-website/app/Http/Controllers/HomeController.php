<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Database\DatabaseManager;
use DB;
use Auth;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }


    public function dash(){

        $userId = Auth::id();

        $current_user = Auth::user();

        $followingProjectsId = DB::table('user_follows')
                            ->select('user_follows.project_id')
                            ->where('user_follows.user_id', '=', $userId)
                            ->get();

        $followingProjectIdArray = array();

        foreach($followingProjectsId as $key => $followingProjectId){
            $followingProjectIdArray[$key] = $followingProjectId->project_id;
        }

        $projects = DB::table('projects')
                    ->select('projects.idProject' ,'projects.naam', 'projects.uitleg', 'projects.foto')
                    ->whereIn('projects.idProject', $followingProjectIdArray)
                    ->get();

        return view('dashboard', [
            'projects' => $projects,
            'current_user' => $current_user,
        ]);
    }


    public function getApplicatieUitleg(){
        return view('applicatie-overzicht');

    }

}
