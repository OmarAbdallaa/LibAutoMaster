<?php
/**
 * Created by PhpStorm.
 * User: raphael
 */


namespace App\Http\Controllers;

use App\Notifications\InboxMessage;
use App\Http\Controllers\Controller;
use App\Admin;

Class FavorisController extends Controller
{
    public function show()
    {
        return view('favoris');
    }

}
