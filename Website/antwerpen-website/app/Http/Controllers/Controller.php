<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Auth;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $current_user;
    protected $isAdmin = false;
    protected $isLoggedIn = false;

    public function __construct(){

        //$this->middleware('auth');

        $this->current_user = Auth::user();

        //dd($this->current_user);

        if(!Auth::guest()){
            $this->current_user = Auth::user();
            $this->isLoggedIn = true;

            if($this->current_user->role == 10){
                $this->isAdmin = true;
            }
            else {
                $this->isAdmin = false;
            }
        }
        else {
            $this->isLoggedIn = false;
        }

      view()->share('current_user', $this->current_user);
      view()->share('isLoggedIn', $this->isLoggedIn);
      view()->share('isAdmin', $this->isAdmin);

    }
}
