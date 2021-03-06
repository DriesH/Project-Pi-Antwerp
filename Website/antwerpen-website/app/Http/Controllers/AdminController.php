<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use File;
use App\Project;
use App\Categorie;
use App\Phase;
use App\Question;
use App\User;
use App\Appquestion;
use Auth;
use Excel;
use App\Multiple_choice_answer;
use DB;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }


    protected function panel(){
        return view('/admin/admin-panel');
    }

    protected function getAdmins(){

      $admins = User::orderBy('name', 'asc')
                ->where('role', '=', 10)
                ->select('name', 'email', 'id')
                ->get();
      return view('/admin/admin-lijst', [
      'admins' => $admins
  ]);
    }

    protected function getAdminVerwijderen($id){

    if (Auth::user()->id != $id) {
      User::where('id', $id)
      ->update([
      'role' => 0
    ]);
      return redirect('/admin/admin-lijst')->with('message', 'Gebruiker is succesvol van zijn administratorrol ontdaan.');
    }
    else {
      return redirect('/admin/admin-lijst')->with('error', 'U kan uzelf niet verwijderen als admin.');
    }

    }

    protected function postNieuweAdmin(Request $request){

      /**
      *Data bevat de values van inputfields.
      *
      *@var array
      */
      $data = Input::all();

      $validator = Validator::make($request->all(), [
          'admin' => 'required'
      ]);

      if ($validator->fails()) {
           return redirect('/admin/admin-lijst')
                      ->withErrors($validator)
                      ->withInput();
      }

      $user = User::where('name', $data['admin'])
      ->orWhere('email', $data['admin'])
      ->first();

      if ($user != null) {
        User::where('name', $data['admin'])
        ->orWhere('email', $data['admin'])
        ->update([
        'role' => 10
    ]);
      }
      else {
        return redirect('/admin/admin-lijst')->with('error', $data['admin'] . ' is geen bestaande gebruiker. Probeer opnieuw.');
      }


      $admins = User::orderBy('name', 'asc')
                ->where('role', '=', 10)
                ->select('name', 'email')
                ->get();

      return redirect('/admin/admin-lijst')->with('message', $user->name . ' is succesvol gepromoveerd tot administrator.');
    }

    /*-----PROJECTEN-----*/

    protected function getNieuwProject(){

        /**
        *categorien een array van alle categorien uit de db.
        *
        *@var array
        */
        $categorien = Categorie::orderBy('naam', 'asc')->get()->pluck('naam', 'idCategorie');

        return view('/admin/nieuw-project', [
        'categorien' => $categorien
    ]);
    }

    protected function postNieuwProject(Request $request)
    {

        //dd( Input::all() );   om input data te testen.

        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'uitleg' => 'required|min:100',
            'locatie' => 'required',
            'foto' => 'image|max:1000',
        ]);

        if ($validator->fails()) {
             return redirect('/admin/nieuwproject/')
                        ->withErrors($validator)
                        ->withInput();
        }

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();


        /**
        *isActief bevat 1 als checkbox aangevinkt is, 0 als deze uitgevinkt is.
        *
        *@var int
        */
        $isActief = (isset($data['isActief'])) ? $data['isActief'] : 0;

        if(Input::hasFile('foto')){
            /**
            *afbeelding is rauwe input data van de aflbeeding
            *
            *@var file
            */
            $maxWidth = 1000;
            $maxHeight = 1000;
            $afbeelding = Input::file('foto');
            $imageDimensions = getimagesize($afbeelding);

            if ($imageDimensions['0'] <= $maxWidth && $imageDimensions['1'] <= $maxHeight ) {
              /**
              *de extensie van afbeelding
              *
              *@var string
              */
              $extensie = $afbeelding->getClientOriginalExtension();

              /**
              *nieuwe unieke naam van de afbeelding
              *
              *@var string
              */
              $nieuwe_naam = uniqid() . "." . $extensie;

              $afbeelding->move('pictures/uploads', $nieuwe_naam);

              /**
              *nieuw pad naar afbeelding
              *
              *@var string
              */
              $foto_path = '/pictures/uploads/' . $nieuwe_naam;

              //dd($foto_path);

              $nieuwProject = Project::create([
                  'naam' => $data['naam'],
                  'uitleg' => $data['uitleg'],
                  'locatie' => $data['locatie'],
                  'foto' => $foto_path,
                  'isActief' => $isActief,
                  'idCategorie' => $data['categorie']
              ]);
            }
            else {
              return redirect('/admin/nieuwproject/')->withInput()->with('error', 'Afbeelding mag maximaal ' . $maxWidth . 'x' . $maxHeight . ' pixels zijn.');
            }
        }
        else {
            $nieuwProject = Project::create([
                'naam' => $data['naam'],
                'uitleg' => $data['uitleg'],
                'locatie' => $data['locatie'],
                'isActief' => $isActief,
                'idCategorie' => $data['categorie']
            ]);

        }


        return redirect('/admin')->with('message', 'Project succesvol toegevoegd.');
    }

    protected function getProjectBewerken($id){

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@var int
        */

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();
        //dd($project);

        /**
        *isActief is 0 of 1 om aan te geven of project actief is of niet.
        *
        *@var int
        */
        $isActief = ($project->isActief == 1) ? true : false;

        /**
        *picpath bevat het pad naar de geuploade afbeelding.
        *
        *@var string
        */
        $picpath = substr($project->foto, 10);

        /**
        *urlpath bevat het pad naar de post action voor het formulier
        *
        *@var string
        */
        $urlpath = "/admin/project-bewerken/" . $project->idProject;

        /**
        *categorien een array van alle categorien uit de db.
        *
        *@var array
        */
        $categorien = Categorie::orderBy('naam', 'asc')->get()->pluck('naam', 'idCategorie');

        return view('/admin/project-bewerken', [
        'project' => $project,
        'isActief' => $isActief,
        'picpath' => $picpath,
        'categorien' => $categorien
    ]);
    }

    protected function postProjectBewerken($id, Request $request)
    {
        //dd( Input::all() );  // om input data te testen.

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();


        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'uitleg' => 'required|min:100',
            'locatie' => 'required',
            'foto' => 'image|max:1000',
        ]);

        if ($validator->fails()) {
             return redirect('/admin/project-bewerken/' . $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        /**
        *isActief bevat 1 als checkbox aangevinkt is, 0 als deze uitgevinkt is.
        *
        *@var int
        */
        $isActief = (isset($data['isActief'])) ? 1 : 0;

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@var int
        */

        if(Input::hasFile('foto')){

            /**
            *afbeelding is rauwe input data van de aflbeeding
            *
            *@var file
            */
            $afbeelding = Input::file('foto');
            $maxWidth = 1000;
            $maxHeight = 1000;
            $imageDimensions = getimagesize($afbeelding);

            if ($imageDimensions['0'] <= $maxWidth && $imageDimensions['1'] <= $maxHeight ) {
              /**
              *de extensie van afbeelding
              *
              *@var string
              */
              $extensie = $afbeelding->getClientOriginalExtension();

              /**
              *nieuwe unieke naam van de afbeelding
              *
              *@var string
              */
              $nieuwe_naam = uniqid() . "." . $extensie;

              //nieuwe afbeelding in uploads plaatsen
              $afbeelding->move('pictures/uploads', $nieuwe_naam);

              /**
              *nieuw pad naar afbeelding
              *
              *@var string
              */
              $foto_path = '/pictures/uploads/' . $nieuwe_naam;

              //oude afbeelding verwijderen uit uploads map
              $project = Project::where('idProject', '=', $id)->first();
              $oude_afbeelding = substr($project->foto, 1);

              if (File::exists($oude_afbeelding)){
                  unlink($oude_afbeelding);
              }

              Project::where('idProject', $id)
              ->update([
                  'naam' => $data['naam'],
                  'uitleg' => $data['uitleg'],
                  'locatie' => $data['locatie'],
                  'foto' => $foto_path,
                  'isActief' => $isActief,
                  'idCategorie' => $data['categorie'],
              ]);
            }
            else {
              return redirect('/admin/project-bewerken/' . $id)->withInput()->with('error', 'Afbeelding mag maximaal ' . $maxWidth . 'x' . $maxHeight . ' pixels zijn.');
            }

        }
        else {
            Project::where('idProject', $id)
            ->update([
            'naam' => $data['naam'],
            'uitleg' => $data['uitleg'],
            'locatie' => $data['locatie'],
            'isActief' => $isActief,
            'idCategorie' => $data['categorie'],
        ]);
        }

        return redirect('/')->with('message', 'Project succesvol bewerkt.');
    }

    protected function getProjectVerwijderen($id){

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        return view('/admin/project-verwijderen', [
        'project' => $project

    ]);

    }

    protected function postProjectVerwijderen($id){

        $project = Project::where('idProject', '=', $id)->first();

        $oude_afbeelding = substr($project->foto, 1);

        if (File::exists($oude_afbeelding)){
            unlink($oude_afbeelding);
        }

        DB::table('projects')->where('idProject', '=', $id)
                            ->delete();

        return redirect('/')->with('message', 'Project succesvol verwijderd.');
    }


    /*-----FASES-----*/

    protected function getFases($id){

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@var int
        */

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        /**
        *fases bevat alle data over de fases van het huidige project.
        *
        *@var array
        */
        $fases = Phase::where('idProject', '=', $id)->orderBy('faseNummer', 'asc')->get();


        return view('/admin/fases-overzicht', [
        'fases' => $fases,
        'project' => $project

    ]);
    }

    protected function getFaseBewerken($id, $faseid){

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@param int
        */

        /**
        *faseid is de idFase van de fase dat men wil bewerken.
        *
        *@param int
        */

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        /**
        *fase bevat alle data over de fases van het huidige project.
        *
        *@var array
        */
        $fase = Phase::where('faseNummer', '=', $faseid)
                    ->where('idProject', '=', $id)->first();

        //dd($fase);


        return view('/admin/fase-bewerken', [
        'fase' => $fase,
        'project' => $project

    ]);
    }

    protected function postFaseBewerken($id, $faseid, Request $request)
    {

        //dd( Input::all() );  // om input data te testen.

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@param int
        */

        /**
        *faseid is de idFase van de fase dat men wil bewerken.
        *
        *@param int
        */

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();


        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'uitleg' => 'required|min:50',
            'start_datum' => 'required'
        ]);

        if ($validator->fails()) {
             return redirect($request->url())
                        ->withErrors($validator)
                        ->withInput();
        }

            Phase::where('faseNummer', '=', $faseid)
                    ->where('idProject', '=', $id)
            ->update([
            'title' => $data['title'],
            'uitleg' => $data['uitleg'],
            'status' => $data['status'],
            'start_datum' => $data['start_datum'],
            'status' => $data['status']
        ]);

        return redirect('/admin/project-bewerken/'. $id . '/fases')->with('message', 'Fase succesvol bewerkt.');
    }

    protected function getFaseVerwijderen($id, $faseid){

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        /**
        *fase bevat alle data over de fases van het huidige project.
        *
        *@var array
        */
        $fase = Phase::where('faseNummer', '=', $faseid)
                    ->where('idProject', '=', $id)->first();

        return view('/admin/fase-verwijderen', [
        'fase' => $fase,
        'project' => $project

    ]);

    }

    protected function postFaseVerwijderen($id, $faseid){

        DB::table('phases')->where('faseNummer', '=', $faseid)
                            ->where('idProject', '=', $id)
                            ->delete();

        return redirect('/admin/project-bewerken/'. $id . '/fases')->with('message', 'Fase succesvol verwijderd.');
    }

    protected function getNieuweFase($id){

        /**
        *id is de idProject van het project waar men een fase wil aan toevoegen.
        *
        *@param int
        */


        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        return view('/admin/nieuwe-fase', [
        'project' => $project

    ]);
    }


    protected function postNieuweFase($id, Request $request){

        /**
        *id is de idProject van het project waar men een fase wil aan toevoegen.
        *
        *@param int
        */

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'uitleg' => 'required|min:50',
            'start_datum' => 'required'
        ]);

        if ($validator->fails()) {
             return redirect($request->url())
                        ->withErrors($validator)
                        ->withInput();
        }

        /**
        *laatsteFase is de fase met het hoogste fasenummer van het project waar men een nieuwe fase wil aan toevoegen.
        *
        *@var array
        */
        $laatsteFase = DB::table('phases')->where('idProject', '=', $id)
                                          ->orderBy('faseNummer', 'desc')
                                          ->first();
        /**
        *nieuweFaseNummer is de faseNummer voor de nieuwe fase.
        *
        *@var int
        */

        if($laatsteFase != null){
            $nieuweFaseNummer = (int)$laatsteFase->faseNummer + 1;
        }
        else {
            $nieuweFaseNummer = 1;
        }


        Phase::create([
                'title' => $data['title'],
                'uitleg' => $data['uitleg'],
                'start_datum' => $data['start_datum'],
                'idProject' => $id,
                'faseNummer' => $nieuweFaseNummer,
                'status' => $data['status']
            ]);


        return redirect('/admin/project-bewerken/'. $id . '/fases')->with('message', 'Fase succesvol toegevoegd.');
    }


    /*-----VRAGEN-----*/

    protected function getVragen($id, $faseid){

        /**
        *id is de idProject van het project dat men wil bewerken.
        *
        *@var int
        */
        /**
        *faseid is de faseNummer van de fase dat men wil bewerken.
        *
        *@var int
        */
        /**
        *vraagid is de idVraag van de vraag dat men wil bewerken.
        *
        *@var int
        */

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        /**
        *fases bevat alle data over de fases van het huidige project.
        *
        *@var array
        */
        $fase = Phase::where('idProject', '=', $id)->orderBy('faseNummer', 'asc')
                 ->where('faseNummer', '=', $faseid)->first();


        $vragen = Question::where('idFase', '=', $fase->idFase)
                 ->get();

        return view('/admin/vragen-overzicht', [
        'fase' => $fase,
        'project' => $project,
        'vragen' => $vragen

    ]);
    }

    protected function getVraagBewerken($id, $faseid, $vraagid){

      /**
      *id is de idProject van het project waar men een fase wil aan toevoegen.
      *
      *@param int
      */


      /**
      *Project is het geselecteerde project uit de database.
      *
      *@var array
      */
      $project = Project::where('idProject', '=', $id)->first();

      $fase = Phase::where('idProject', '=', $id)->orderBy('faseNummer', 'asc')
               ->where('faseNummer', '=', $faseid)->first();

      $vraag = Question::where('idvraag', '=', $vraagid)->first();

      if($vraag->soort_vraag == "Meerkeuze"){
        $antwoorden = Multiple_choice_answer::where('idvraag', '=', $vraagid)->first()->toArray();
      }
      else {
        $antwoorden = null;
      }

      return view('/admin/vraag-bewerken', [
          'project' => $project,
          'fase' => $fase,
          'vraag' => $vraag,
          'antwoorden' => $antwoorden,
      ]);
    }

    protected function postVraagBewerken($id, $faseid, $vraagid, Request $request)
    {

        /**
        *id is de idProject van het project waar men een fase wil aan toevoegen.
        *
        *@param int
        */

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();

        if($data['soort_vraag'] == "Meerkeuze"){
          $validator = Validator::make($request->all(), [
              'vraag' => 'required',
              'antwoord_1' => 'required',
              'antwoord_2' => 'required',
          ]);
        }
        else {
          $validator = Validator::make($request->all(), [
              'vraag' => 'required',
          ]);
        }

        if ($validator->fails()) {
             return redirect($request->url())
                        ->withErrors($validator)
                        ->withInput();
        }


        $vraag_soort_before = Question::where('idvraag', '=', $vraagid)->first()->soort_vraag;
        if ($vraag_soort_before == "Meerkeuze" && $data['soort_vraag'] != "Meerkeuze") {
          DB::table('multiple_choice_answers')->where('idVraag', '=', $vraagid)
                                ->delete();
        }
        else if ($vraag_soort_before != "Meerkeuze" && $data['soort_vraag'] == "Meerkeuze") {

          $data['antwoord_3'] = ($data['antwoord_3'] == "") ? null : $data['antwoord_3'];
          $data['antwoord_4'] = ($data['antwoord_4'] == "") ? null : $data['antwoord_4'];

          Multiple_choice_answer::create([
                  'antwoord_1' => $data['antwoord_1'],
                  'antwoord_2' => $data['antwoord_2'],
                  'antwoord_3' => $data['antwoord_3'],
                  'antwoord_4' => $data['antwoord_4'],
                  'idVraag' => $vraagid,

              ]);
        }
        else if ($vraag_soort_before == "Meerkeuze" && $data['soort_vraag'] == "Meerkeuze") {
          Multiple_choice_answer::where('idVraag', '=', $vraagid)
          ->update([
                  'antwoord_1' => $data['antwoord_1'],
                  'antwoord_2' => $data['antwoord_2'],
                  'antwoord_3' => $data['antwoord_3'],
                  'antwoord_4' => $data['antwoord_4']
              ]);
        }

        Question::where('idVraag', '=', $vraagid)
        ->update([
          'vraag' => $data['vraag'],
          'soort_vraag' => $data['soort_vraag']
        ]);

        return redirect('/admin/project-bewerken/'. $id . '/fases/' . $faseid . '/vragen')->with('message', 'Vraag succesvol aangepast.');

    }

    protected function getVraagVerwijderen($id, $faseid, $vraagid){

        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        /**
        *fase bevat alle data over de fases van het huidige project.
        *
        *@var array
        */
        $fase = Phase::where('faseNummer', '=', $faseid)
                    ->where('idProject', '=', $id)->first();

        $vraag = Question::where('idvraag', '=', $vraagid)->first();

        return view('/admin/vraag-verwijderen', [
        'fase' => $fase,
        'project' => $project,
        'vraag' => $vraag

    ]);

    }

    protected function postVraagVerwijderen($id, $faseid, $vraagid){

        DB::table('questions')->where('idVraag', '=', $vraagid)
                              ->delete();

        return redirect('/admin/project-bewerken/'. $id . '/fases/' . $faseid . '/vragen')->with('message', 'Vraag succesvol verwijderd.');
    }

    protected function getNieuweVraag($id, $faseid){

        /**
        *id is de idProject van het project waar men een fase wil aan toevoegen.
        *
        *@param int
        */


        /**
        *Project is het geselecteerde project uit de database.
        *
        *@var array
        */
        $project = Project::where('idProject', '=', $id)->first();

        $fase = Phase::where('idProject', '=', $id)->orderBy('faseNummer', 'asc')
                 ->where('faseNummer', '=', $faseid)->first();

        return view('/admin/nieuwe-vraag', [
            'project' => $project,
            'fase' => $fase
        ]);
    }

    protected function postNieuweVraag($id, $faseid, Request $request){

        /**
        *id is de idProject van het project waar men een fase wil aan toevoegen.
        *
        *@param int
        */

        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */
        $data = Input::all();

        if($data['soort_vraag'] == "Meerkeuze"){
          $validator = Validator::make($request->all(), [
              'vraag' => 'required',
              'antwoord_1' => 'required',
              'antwoord_2' => 'required',
          ]);
        }
        else {
          $validator = Validator::make($request->all(), [
              'vraag' => 'required',
          ]);
        }

        if ($validator->fails()) {
             return redirect($request->url())
                        ->withErrors($validator)
                        ->withInput();
        }

        $fase = Phase::where('idProject', '=', $id)->orderBy('faseNummer', 'asc')
                 ->where('faseNummer', '=', $faseid)
                 ->first(array('idFase'));


        $nieuweVraag = Question::create([
                'vraag' => $data['vraag'],
                'soort_vraag' => $data['soort_vraag'],
                'idFase' => $fase->idFase
            ])->id;

            $data['antwoord_3'] = ($data['antwoord_3'] == "") ? null : $data['antwoord_3'];
            $data['antwoord_4'] = ($data['antwoord_4'] == "") ? null : $data['antwoord_4'];

            if($data['soort_vraag'] == "Meerkeuze"){
              Multiple_choice_answer::create([
                      'antwoord_1' => $data['antwoord_1'],
                      'antwoord_2' => $data['antwoord_2'],
                      'antwoord_3' => $data['antwoord_3'],
                      'antwoord_4' => $data['antwoord_4'],
                      'idVraag' => $nieuweVraag,

                  ]);
            }


        return redirect('/admin/project-bewerken/'. $id . '/fases/' . $faseid . '/vragen')->with('message', 'Vraag succesvol toegevoegd.');
    }

    protected function getProjectLijst(){

        $projecten = DB::table('projects')
                      ->select('naam', 'foto', 'created_at', 'uitleg', 'idProject', 'isActief')
                      ->orderBy('projects.isActief', 'desc')
                      ->orderBy('projects.created_at', 'desc')
                      ->get();

        $dataProject = DB::table('projects')
                        ->join('phases', 'projects.idProject', '=', 'phases.idProject')
                        ->join('questions', 'phases.idFase', '=', 'questions.idFase')
                        ->join('answers', 'questions.idVraag', '=', 'answers.idVraag')
                        ->select('projects.*', 'questions.*', 'answers.*')
                        ->get();

        $usersProject = DB::table('projects')
                        ->join('user_follows', 'projects.idProject', '=', 'user_follows.project_id')
                        ->select('user_follows.*')
                        ->get();



        $amountAnswers   = 0;
        $amountFollowers = 0;
        $prevUser        = 0;

        return view('/admin/project-lijst', [
            'projecten' => $projecten,
            'dataProject' => $dataProject,
            'usersProject' => $usersProject,
            'amountAnswers' => $amountAnswers,
            'amountFollowers' => $amountFollowers,
            'prevUser' => $prevUser,
        ]);
    }
    protected function getDownloadFeedback($id){

      $project = DB::table('projects')
                    ->where('idProject', '=', $id)
                    ->first();

      $dataProject = DB::table('phases')
                      ->where( 'phases.idProject' , '=', $id)
                      ->join('questions', 'phases.idFase', '=', 'questions.idFase')
                      ->join('answers', 'questions.idVraag', '=', 'answers.idVraag')
                      ->orderBy('phases.idFase', 'asc')
                      ->orderBy('questions.idVraag', 'asc')
                      ->orderBy('answers.antwoord', 'asc')
                      ->get();


      Excel::create('Feedback_Project_' . $project->naam, function($excel) use($project, $dataProject) {


        $excel->sheet('ProjectInfo', function($sheet) use($project, $dataProject) {

          $sheet->row(1, array(
            'Naam', 'Uitleg', 'Locatie', 'Aangemaakt op'
            ))->setWidth(array(
            'A'     =>  60,
            'B'     =>  30,
            'C'     =>  40,
            'D'     =>  40
            ));

            $sheet->cells('A4:D4', function($cells) {
              $cells->setBackground('#000000');
            });
            $sheet->cells('A1:D1', function($cells) {
              $cells->setFontWeight('bold');
            });
            $sheet->cells('A6:B6', function($cells) {
              $cells->setFontWeight('bold');
            });



          $sheet->row(2, array(
            $project->naam, $project->uitleg, $project->locatie, $project->created_at
          ));

          $sheet->row(6, array(
            'Appvraag', 'Antwoord'
          ));

          $allAppAnswersOfProject = DB::table('appanswers')
                                ->join('appquestions', 'appanswers.idAppquestions', '=', 'appquestions.idAppquestions')
                                ->where('appquestions.idProject', '=', $project->idProject)
                                ->orderBy('appanswers.answer', 'asc')
                                ->get();

          foreach ($allAppAnswersOfProject as $appAnswer_Question) {
            $sheet->appendRow(array(
              $appAnswer_Question->question, $appAnswer_Question->answer
            ));
          }

      });

      $currentPhase = 0;

      for ($i=0; $i < count($dataProject); $i++) {
        if($dataProject[$i]->idFase !=  $currentPhase){
          $currentPhase = $dataProject[$i]->idFase;

          $excel->sheet('Fase_' . $dataProject[$i]->faseNummer, function($sheet) use($project, $dataProject, $currentPhase) {

            $sheet->appendRow(array(
              'Vraag', 'Antwoord'
            ));

            for ($i=0; $i < count($dataProject); $i++) {
              if ($dataProject[$i]->idFase ==  $currentPhase) {
                $sheet->appendRow(array(
                  $dataProject[$i]->vraag, $dataProject[$i]->antwoord
                ))->setStyle(array(
                  'font' => array(
                  'bold'      =>  false
                  )
                ))->setWidth(array(
                'A'     =>  60,
                'B'     =>  30
                ));
              }
            }
            $sheet->cells('A1:B1', function($cells) {
              $cells->setFontWeight('bold');
            });



        });

        }
      }

    })->export('xlsx');

      return redirect('/admin/project-lijst/');

    }

    protected function getAppVragen($id){

      $project = DB::table('projects')
                    ->where('idProject', '=', $id)
                    ->first();

      $appQuestions = Appquestion::where('idProject', '=', $id)
                      ->get();



        return view('/admin/appvragen-overzicht', [
            'project' => $project,
            'appQuestions' => $appQuestions,
        ]);
    }

    protected function getAppVraagBewerken($id, $vraagid){

      $project = DB::table('projects')
                    ->where('idProject', '=', $id)
                    ->first();

      $appquestion = Appquestion::where('idAppquestions', '=', $vraagid)
                      ->first();



        return view('/admin/appvraag-bewerken', [
            'project' => $project,
            'appquestion' => $appquestion,
        ]);
    }

    protected function postAppVraagBewerken($id, $vraagid, Request $request){

      $data = Input::all();

      $validator = Validator::make($request->all(), [
          'vraag' => 'required'
      ]);

      if ($validator->fails()) {
           return redirect($request->url())
                      ->withErrors($validator)
                      ->withInput();
      }

      Appquestion::where('idAppquestions', $vraagid)
      ->update([
          'question' => $data['vraag']
      ]);

        return redirect('/admin/project-bewerken/' . $id . '/appvragen')->with('message', 'Appvraag succesvol aangepast.');
    }


    protected function getNieuweAppVraag($id){

      $project = DB::table('projects')
                    ->where('idProject', '=', $id)
                    ->first();



        return view('/admin/nieuwe-appvraag', [
            'project' => $project
        ]);
    }

    protected function postNieuweAppVraag($id, Request $request){

      $data = Input::all();

      $validator = Validator::make($request->all(), [
          'vraag' => 'required'
      ]);

      if ($validator->fails()) {
           return redirect($request->url())
                      ->withErrors($validator)
                      ->withInput();
      }

      Appquestion::create([
          'question' => $data['vraag'],
          'idProject' => $id
      ]);


        return redirect('/admin/project-bewerken/' . $id . '/appvragen')->with('message', 'Appvraag succesvol toegevoegd.');
    }

    protected function getAppVraagVerwijderen($id, $vraagid){

      $project = DB::table('projects')
                    ->where('idProject', '=', $id)
                    ->first();

      $appquestion = Appquestion::where('idAppquestions', '=', $vraagid)
                    ->first();

        return view('/admin/appvraag-verwijderen', [
            'project' => $project,
            'appquestion' => $appquestion
        ]);
    }

    protected function postAppVraagVerwijderen($id, $vraagid){

      DB::table('appquestions')->where('idAppquestions', '=', $vraagid)
                          ->delete();

      return redirect('/admin/project-bewerken/' . $id . '/appvragen')->with('message', 'Appvraag succesvol verwijderd.');
    }




}
