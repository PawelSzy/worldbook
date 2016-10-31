<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Traits\ControllerTrait;


/**
* Klasa obsluguje rankingi - np.: kraje o najwieszkszej populacji, o najwiekszym GDP 
*/
class RankingiController extends CzytajRekordController
{

    use ControllerTrait;
	/**
    *funkcja zwraca nazwy rankingow po ktorych mozemy przeszukiwac
    * @return - json {"id rankingu", "nazwa rankingu"}
    */
    public function wyswietlRankingi($json_true = "json_false") {
	        $idRankingow = \App\factbook_ranks::pluck('fieldid')->unique();

	        $rankingi = array();

	        foreach ($idRankingow as $idPola) {
	        	$rankingi[$idPola] = $this->zwrocNazwePola( $idPola );
	        }

	        return response()->json( $rankingi );
    }

    /**
    *Zwroc nazwe krajow o wybranych rankingu
    * @param - int, id rankingu w bazie danych; int liczba krajow ktore ma byc zwrocona
    * @return - json lub strona html 
    */
    public function wyswietlRanking($idRankingu, $liczba_krajow = 10) {
    	//pobierz ranking - ranking podany jest w skroteach
        $ranking = $this->czytajRanking( $idRankingu, $liczba_krajow);

    	$nazwaRankingu = $this->zwrocNazwePola( $idRankingu );



        $skrotyKrajow = $ranking->pluck("country");    
        $daneKrajow = $this->daneKrajow( $skrotyKrajow);


        $ranking = $ranking->keyBy('country')->sortBy("country");
        $daneKrajow = $daneKrajow->keyBy('xmlid')->sortBy("xmlid");


        //polacz ranking z nazwami krajow
        $daneKrajow = $this->zmiksujCollection($ranking, $daneKrajow, "name");


        
        $daneKrajow = $daneKrajow->sortByDesc("number");

        //zwroc dane
        $daneKrajow = $daneKrajow->pluck("number", "name");
        $daneKrajow = collect(array($nazwaRankingu => $daneKrajow)  );
    	return response()->json( $daneKrajow );

    }

    /**
    * Pobierz z bazy danych dane krajow
    * @param - array of string
    * @return - collection
    */
    private function daneKrajow( $skrotyKrajow ) {
    	$daneKrajow =  \App\factbook_countries::select('id', 'name', 'xmlid')->whereIn('xmlid', $skrotyKrajow)->get();
    	return $daneKrajow;	
    }


    /**
    * Odczytaj ranking 
    * @param int - id ranking w bazie danych, int - liczba krajow
    * @return collection - zawiera liczby country, number 
    */
    private function czytajRanking($idRankingu, $liczba_krajow = 10)
    {
		$skrotyKrajow = \App\factbook_ranks::orderBy('id', 'asc')->select('country', 'number')->where("fieldid", $idRankingu)->take($liczba_krajow)->get();
		return $skrotyKrajow;
    }


	/**
	*funkcja czyta pojedyncze dane o danym kraju np.: wartośc GDP, Populacje, 
	* @param - array id kraju, id rekordu
	* @return - json zawierajacy  {nazwa_rekordu: wartosc_rekordu)
	*/
    public function czytajRekordyPoId( $idKrajow, $idRekordu ) {

        if( $idKrajow == NULL ){
            return NULL;
        }
    	$daneRekordu = \App\factbook_values::whereIn('countryid', $idKrajow)->where("fieldid", $idRekordu)->get();
    	return $daneRekordu;
    }





}
