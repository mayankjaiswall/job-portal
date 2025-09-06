<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //This is index funtion
    public function index()
    {
        return view('front.home');
    }
}
