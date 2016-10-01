<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class KrajController extends Controller
{

	//funkcja wyswietla opis kraju
	// @param - string nazwa kraju
	// @return - widok - Kraj - wyswietla wszystkie dane na temat danego Kraju
    public function wyswietlKraj($nazwa_kraju) {
    	// echo "Nazwa Kraju ".$nazwa_kraju ;

    	$kraj = array(
   			$nazwa_kraju => array(
   				"wstep" =>"Pieknie rozwijajacy sie kraj.",
   				"geografia" => "Bez dostepu do morza, kraj polozony pomiedzy dwoma wrogimi krajami",
   				"gdp" => 123456)
    		// "dane_kraju" => array(

    		// 	'Wstep' => "Doskonale rozwijajacy sie stan",
    		// 	'GDP' => 2345667,
    		// 	'Lokalizacja' => "blisko morza"
    		// 	 )
		);

    	return view('Kraj')->with('kraj', $kraj);
    }
}
