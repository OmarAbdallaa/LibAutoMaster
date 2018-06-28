<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

use App\Admin;

Class FaqController extends Controller
{
	public function show() 
	{
		return view('faq');
	}


}
