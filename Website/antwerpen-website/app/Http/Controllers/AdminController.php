<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use File;

use App\Project;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    
    protected function panel(){
        return view('\admin\admin-panel');
    }
    
    protected function getNieuwProject(){
        return view('\admin\nieuw-project');
    }
    
    protected function postNieuwProject(Request $request)
    {
        
        //dd( Input::all() );   om input data te testen.
        
        $validator = Validator::make($request->all(), [
            'naam' => 'required',
            'uitleg' => 'required',
            'locatie' => 'required',
            'foto' => 'image|max:1000',
        ]);
        
        if ($validator->fails()) {
             return redirect('/admin/nieuwproject/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if(Input::hasFile('foto')){
            /**
            *afbeelding is rauwe input data van de aflbeeding
            *
            *@var file
            */
            $afbeelding = Input::file('foto');
            
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

        }
        
        /**
        *nieuw pad naar afbeelding
        *
        *@var string
        */
        $foto_path = '/pictures/uploads/' . $nieuwe_naam;
        
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
        
        //dd($data);
        
        Project::create([
            'naam' => $data['naam'],
            'uitleg' => $data['uitleg'],
            'locatie' => $data['locatie'],
            'foto' => $foto_path,
            'isActief' => $isActief,
            'idCategorie' => 5
        ]);
        
        
        return view('\admin\admin-panel');
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
        *@var int
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
       
        return view('\admin\project-bewerken', [
        'project' => $project,
        'isActief' => $isActief,
        'picpath' => $picpath,
        'urlpath' => $urlpath
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
            'uitleg' => 'required',
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
            'idCategorie' => 5
        ]);
        }
        else {
            Project::where('idProject', $id)
            ->update([
            'naam' => $data['naam'],
            'uitleg' => $data['uitleg'],
            'locatie' => $data['locatie'],
            'isActief' => $isActief,
            'idCategorie' => 5
        ]);
        }
        
        return redirect('/');
    }
}
