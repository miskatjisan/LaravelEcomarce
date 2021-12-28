<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    
    


    public function English_Language(){
        Session()->get('language');
        Session()->forget('language');
        Session::put('language','english');
        return redirect()->back();


    }



    public function Others_language(){
        Session()->get('language');
        Session()->forget('language');
        Session::put('language','others');
        return redirect()->back();
    }






}
