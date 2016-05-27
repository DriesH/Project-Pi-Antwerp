<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AppPageController extends Controller
{
    public function getApplicatieUitleg(){
        return view('applicatie-overzicht');

    }
}
