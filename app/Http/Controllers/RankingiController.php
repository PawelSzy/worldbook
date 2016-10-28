<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


/**
* Klasa obsluguje rankingi - np.: kraje o najwieszkszej populacji, o najwiekszym GDP 
*/
class RankingiController extends CzytajRekordController
{
	/**
    *funkcja zwraca nazwy rankingow po ktorych mozemy przeszukiwac
    * @return - string, nazwa pola
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
    *Zwroc nazwe krajow o najwiekszych 
    * @param - zwraca 
    */
    public function wyswietlRanking($idRankingu, $liczba_krajow = 10) {
    	$skrotyKrajow = $this->podajSkrotyKrajow( $idRankingu, $liczba_krajow);

    	// $nazwyKrajow = array_map(array($this, 'zwrocNazweKrajuPoSkrocie'), json_decode($skrotyKrajow ));


    	$nazwaRankingu = $this->zwrocNazwePola( $idRankingu );

    	// $daneKrajow = $this->daneKrajow( $skrotyKrajow );

    	// $ids = array();
    	// foreach ($daneKrajow as $kraj) {
    	// 	array_push($ids, $kraj["id"]); 
    	// };

    	// $wartosciRekordu = $this->czytajRekordyPoId( $ids, $idRankingu );


    	// $ranking = array();

    	// $ranking["nazwa_rankingu"] = $nazwaRankingu;

    	// $ranking["wartosciRankingu"] = $this->daneKrajow($skrotyKrajow);

    	return response()->json( $skrotyKrajow );

    }



    private function daneKrajow($skrotyKrajow) {
    	$daneKrajow =  \App\factbook_countries::select('id', 'name', 'xmlid')->whereIn('xmlid', $skrotyKrajow)->get();
    	return $daneKrajow;	
    }



    private function podajSkrotyKrajow($idRankingu, $liczba_krajow = 10)
    {
		$skrotyKrajow = \App\factbook_ranks::orderBy('id', 'asc')->select('country', 'number')->where("fieldid", $idRankingu)->paginate( $liczba_krajow);
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
