<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CzytajRekordController extends CzytajDane
{
	/**
	*funkcja czyta pojedyncze dane o danym kraju np.: wartośc GDP, Populacje, 
	* @param - string nazwa kraju, nazwa rekordu
	* @return - json zawierajacy  {nazwa_rekordu: wartosc_rekordu)
	*/
    public function czytajRekord($nazwa_kraju, $idRekordu, $json_true = true) {
    	
    	$idKraju = $this->znajdzIdKraju( $nazwa_kraju);

    	return $this->CzytajRekordPoId( $idKraju, $idRekordu );

    }


    public function czytajRekordPoId( $idKraju, $idRekordu ) {

        if( $idKraju == NULL ){
            return NULL;
        }
    	$daneRekorduJSON = \App\factbook_values::where('countryid', $idKraju)->where("fieldid", $idRekordu)->get();
    	$daneRekordu = json_decode( $daneRekorduJSON, true );
    	return json_encode($daneRekordu[0]["value"]) ;
    }

}
