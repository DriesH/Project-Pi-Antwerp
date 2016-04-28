<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Project;
use App\Phase;
use Illuminate\Http\Request;

Route::get('/', function () {
    /**
    *Array bevat alle projecten en hun data.
    *
    *@var array
    */
    $projecten = Project::orderBy('idProject', 'asc')->get();

    return view('projecten', [
        'projecten' => $projecten
    ]);
});


Route::get('/project/{id}', function($id) {

    /**
    *Array bevat de data van een enkel project.
    *
    *@var array
    */
    $project = Project::where('idProject', '=', $id)->first();

    /**
    *Array dat de fases bevat.
    *
    *@var array
    */
    $phases = Phase::where('idProject', '=', $id)->get();

    return view('project', [
        'project' => $project,
        'phases' => $phases
    ]);
});


// Authentication Routes...
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
/*Route::get('auth/logout', 'Auth\AuthController@getLogout');*/
Route::get('/auth/logout', function()
{
    Auth::logout();
    return Redirect::to('/auth/login');
});
// Registration Routes...
Route::get('/auth/register', 'Auth\AuthController@getRegister');
Route::post('/auth/register', 'Auth\AuthController@postRegister');

/*--Profiel--*/
Route::get('/dashboard', 'HomeController@dash');

/*Admin*/
Route::get('/admin', 'AdminController@panel');
