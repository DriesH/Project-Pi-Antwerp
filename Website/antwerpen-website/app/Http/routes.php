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
use App\User;
use App\Phase;
use App\Question;
use App\User_follow;
use App\Categorie;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;


//!!!!!!!!NIEUWE CLASSES ALTIJD INCLUDEN DOOR "USE"!!!!!!!!//

//get all projects
Route::get('/', 'ProjectController@GetProjects');

//get 1 project + check if following or not
Route::get('/project/{id}', 'ProjectController@GetProject');

//post follow to data base
Route::post('/project/{id}', 'ProjectController@PostProjectFollow');

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

/*Admin-panel*/
Route::get('/admin', 'AdminController@panel');

/*Project routes*/
Route::get('/admin/nieuwproject', 'AdminController@getNieuwProject');
Route::post('/admin/nieuwproject', 'AdminController@postNieuwProject');
Route::get('/admin/project-bewerken/{id}', 'AdminController@getProjectBewerken');
Route::post('/admin/project-bewerken/{id}', 'AdminController@postProjectBewerken');
Route::get('/admin/project-bewerken/{id}/verwijderen', 'AdminController@getProjectVerwijderen');
Route::post('/admin/project-bewerken/{id}/verwijderen', 'AdminController@postProjectVerwijderen');

/*Fase routes*/
Route::get('/admin/project-bewerken/{id}/fases', 'AdminController@getFases');
Route::get('/admin/project-bewerken/{id}/fases/{faseid}', 'AdminController@getFaseBewerken');
Route::post('/admin/project-bewerken/{id}/fases/{faseid}', 'AdminController@postFaseBewerken');
Route::get('/admin/project-bewerken/{id}/fases/verwijderen/{faseid}', 'AdminController@getFaseVerwijderen');
Route::post('/admin/project-bewerken/{id}/fases/verwijderen/{faseid}', 'AdminController@postFaseVerwijderen');
Route::get('/admin/project-bewerken/{id}/nieuwefase', 'AdminController@getNieuweFase');
Route::post('/admin/project-bewerken/{id}/nieuwefase', 'AdminController@postNieuweFase');
