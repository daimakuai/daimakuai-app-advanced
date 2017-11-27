<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index()
    {
        $items = [

        ];

        return view('home.index', $items)->render();
    }

    public function welcome()
    {
        return View('home.welcome');
    }
}
