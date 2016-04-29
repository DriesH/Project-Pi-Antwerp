<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

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
    
    protected function postNieuwProject()
    {
        
        //dd( Input::all() );   om input data te testen.
        
        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */        
        $data = Input::all();
        
        /**
        *picpath bevat het pad naar de geuploade afbeelding.
        *
        *@var string
        */   
        $picpath = "/pictures/" . $data['foto'];
        
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
            'foto' => $picpath,
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
        $isActief = ($project->isActief == 1) ? "true" : null;
        
        /**
        *picpath bevat het pad naar de geuploade afbeelding.
        *
        *@var string
        */   
        $picpath = substr($project->foto, 10);
        
        $urlpath = "/admin/project-bewerken/" . $project->idProject;
        
        return view('\admin\project-bewerken', [
        'project' => $project,
        'isActief' => $isActief,
        'picpath' => $picpath,
        'urlpath' => $urlpath
    ]);
    }
    
    protected function postProjectBewerken($id)
    {
        
        //dd( Input::all() );  // om input data te testen.
        
        /**
        *Data bevat de values van inputfields van het nieuwe project.
        *
        *@var array
        */        
        $data = Input::all();
        
        /**
        *picpath bevat het pad naar de geuploade afbeelding.
        *
        *@var string
        */   
        $picpath = (isset($data['foto']))?"/pictures/" . $data['foto']:"";
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
        
        
        dd($data);
        
        /*Project->where('idProject', $id)
            ->update([
            'naam' => $data['naam'],
            'uitleg' => $data['uitleg'],
            'locatie' => $data['locatie'],
            'foto' => $picpath,
            'isActief' => $isActief,
            'idCategorie' => 5
        ]);*/
        
        
        return view('\admin\admin-panel');
    }
}
