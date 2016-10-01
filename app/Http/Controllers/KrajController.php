<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class KrajController extends Controller
{
    public function wyswietlKraj($nazwa_kraju) {
    	// echo "Nazwa Kraju ".$nazwa_kraju ;

    	return view('Kraj');
    }
}
