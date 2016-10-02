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

    	$kraj = $this->zwrocDaneKraju($nazwa_kraju);

    	return view('Kraj')->with('kraj', $kraj);
    }


    private function zwrocDaneKraju($nazwa_kraju) {

    	//sluzy do testowania wyswietlania kraju
    	if ($nazwa_kraju == "angbar") {
		  $kraj = array(
		   			$nazwa_kraju => array(
		   				"Informacje wstępne" =>"Angmar został założony około 1300 roku Trzeciej Ery, na północnym krańcu Gór Mglistych, 
		   				przez Wodza Nazgûli, przywódcę Upiorów Pierścienia, którego odtąd nazywano Czarnoksiężnikiem z Angmaru, bowiem ukrywał swoją prawdziwą tożsamość. 
		   				Większość jego poddanych stanowili ludzie z gór i orkowie. Państwo to sięgało swoim obszarem w okolice Ettenmoors. Jego głównym ośrodkiem i stolicą było Carn Dûm. 
		   				Ponieważ Czarnoksiężnik był sługą Saurona, uważa się, że wojny z państwami Dúnedainów, powstałymi w wyniku podziału królestwa Arnoru na Arthedain, Cardolan i Rhudaur, prowadzone były przez Angmar z rozkazu Władcy Ciemności. 
		   				Skłócenia tamtejszych władców było dla Czarnoksiężnika bardzo korzystne..",
		   				"geografia" => "Górzysty kraj, bez dostepu do morza,położony pomiedzy Arthedainem a Rhohanem",
		   				"gdp" => 75767687876,
		   				"waluta" => "zlote Saurony")
				);  
			return $kraj; 		
    	}

    	$krajBaza = \App\factbook_countries::find(3);

      	$kraj = array(
   			$nazwa_kraju => array(
   				"wstep" =>$krajBaza->name,
   				"geografia" => "Bez dostepu do morza, kraj polozony pomiedzy dwoma wrogimi krajami",
   				"gdp" => 123456)

		);
		
		return $kraj; 	
    }
}
