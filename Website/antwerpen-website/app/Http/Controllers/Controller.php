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

      $this->current_user = "test";

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


      View::share([ 'current_user' => $this->current_user,
                    'isLoggedIn' => $this->isLoggedIn,
                    'isAdmin' => $this->isAdmin]);
    }
}
