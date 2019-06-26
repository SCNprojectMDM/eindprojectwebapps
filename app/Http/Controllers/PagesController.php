<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    // maak een variablele aan om standaard info mee te geven wanneer de pagina word opgevraagd

    public function index(){
        $title = 'WebApps Eindopdracht';
        return view('pages.index')->with('title', $title);
    }


}
