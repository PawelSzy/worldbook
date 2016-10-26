<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CzytajRekordController extends CzytajDane
{
	/**
	*funkcja czyta pojedyncze dane o danym kraju np.: wartośc GDP, Populacje, 
	* @param - string nazwa kraju, id rekordu
	* @return - json zawierajacy  {nazwa_rekordu: wartosc_rekordu)
	*/
    public function czytajRekord($nazwa_kraju, $idRekordu, $json_true = "json_false") {
    	

    	//odczyt z bazy danych
    	$idKraju = $this->znajdzIdKraju( $nazwa_kraju);
    	$daneRekorduJSON = $this->CzytajRekordPoId( $idKraju, $idRekordu );
    	$daneRekordu = json_decode( $daneRekorduJSON, true )[0]["value"];


		$nazwaPola = $this->zwrocNazwePola( $idRekordu );	

    	//zwroc w formacie Json
    	if ($json_true == "json_true"){
    	   	return json_encode( array($nazwaPola => $daneRekordu) ) ;
    	}

    	//wyswietl strone html
  		$kraj = array(
                $nazwa_kraju => array(
             		$nazwaPola => $daneRekordu
                )                
            );  
        return view('pojedyncze_dane_kraj')->with('kraj', $kraj );
    }


	/**
	*funkcja czyta pojedyncze dane o danym kraju np.: wartośc GDP, Populacje, 
	* @param - id kraju, id rekordu
	* @return - json zawierajacy  {nazwa_rekordu: wartosc_rekordu)
	*/
    public function czytajRekordPoId( $idKraju, $idRekordu ) {

        if( $idKraju == NULL ){
            return NULL;
        }
    	$daneRekorduJSON = \App\factbook_values::where('countryid', $idKraju)->where("fieldid", $idRekordu)->get();
    	return $daneRekorduJSON;
    }

}
