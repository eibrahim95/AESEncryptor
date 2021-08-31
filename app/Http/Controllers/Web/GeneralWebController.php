<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneralWebController extends Controller
{
    public function index(){
        if (! session()->has('token')){
            session()->put('token',  Str::random(32));
        }
        return view('index');
    }
}
