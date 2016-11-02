<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Traits\CollectionTrait;


/**
* Klasa obsluguje rankingi - np.: kraje o najwieszkszej populacji, o najwiekszym GDP 
*/
class RankingiController extends CzytajRekordController
{

    // use CollectionTrait;
    
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


            if ($json_true == "json_true") {
                return response()->json( $rankingi );
            } 
            else {
                return view('rankingi')->with('dane_rankingu', $rankingi );
            };
    }

    /**
    *Zwroc nazwe krajow o wybranych rankingu
    * @param - int, id rankingu w bazie danych; int liczba krajow ktore ma byc zwrocona
    * @return - json lub strona html 
    */
    public function wyswietlRanking($idRankingu, $liczba_krajow = 10, $json_true = "json_false") {
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


    public function wyswietlRankingHTML(Request $request)
    {
            // $id = Inpu::get('id') ; 


            $idRankingu =  $request->input('rankingi');
            return $this->wyswietlRanking($idRankingu); 
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
    private function czytajRekordyPoId( $idKrajow, $idRekordu ) {

        if( $idKrajow == NULL ){
            return NULL;
        }
    	$daneRekordu = \App\factbook_values::whereIn('countryid', $idKrajow)->where("fieldid", $idRekordu)->get();
    	return $daneRekordu;
    }


    /**
    * Polacz dwie kollekcje (collection) 
    * np.: kol1 = collect( (array("Polska", "Europa"), array("Niemcy", "Europa"); kol2 = collect(array("36 milionow", "dostep do morza"), array("84 miliony", "dostep do morza")
    * miks = zmiksujCollection(kol1, kol2)
    * miks->toArray(); zwroci [("Polska, Europa", "36 milionow", "dostep, do morza"), ("Niemcy", "Europa", "84 miliony", "dostep do morza")]
    * @param - collection, collection, string or number
    * @return - collection
    */
    public function zmiksujCollection($collection1, $collection2, $newKey = null) {    

        $array1 = $collection1->toArray(); 
        $array2 = $collection2->toArray();

        $zlaczonyArray = array_merge_recursive( $array1, $array2);



        if ($newKey == null) {
            return collect( $zlaczonyArray );
        } 
        else {
            $returnArray = array();

            foreach ($zlaczonyArray as $key => $value) {
                // $returnArray[ $value[ $newKey ] ] = $value;
                array_push($returnArray, $value );
            }

            $returnCollection = collect( $returnArray);
            $returnCollection = $returnCollection->keyBy( $newKey );

            return $returnCollection;

        }
    }


}
