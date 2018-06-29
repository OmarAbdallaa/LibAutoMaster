<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Admin;

Class FaqController extends Controller
{
	public function show() 
	{

        $results = DB::select('SELECT * FROM `faq`');

//        echo Auth::user()->getAuthIdentifier();die;

		return view('faq', ['faq'=>$results]);
	}


}
