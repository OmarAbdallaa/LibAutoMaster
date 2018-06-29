<?php
/**
 * Created by PhpStorm.
 * User: raphael
 */


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Admin;

Class FavorisController extends Controller
{
    public function show()
    {
        $results = DB::select('SELECT * FROM `favoris` WHERE idtUser =? ', [Auth::user()->getAuthIdentifier()]);
        return view('favoris', ['favoris' => $results]);
    }

}
