<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class KrajController extends Controller
{

	/** 
    *funkcja wyswietla opis kraju
	* @param - string nazwa kraju
	* @return - widok - Kraj - wyswietla wszystkie dane na temat danego Kraju
    */
    public function wyswietlKraj($nazwa_kraju, $json = null) {

        #sluzy do testowania wyswietlania kraju
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
                        "waluta" => "zlote Saurony"
                    )                
                );  
            return view('Kraj')->with('kraj', $kraj );
        }


        //zamien nazwe kraju z url na mozliwa do wyszukanie w bazie danych
        $nazwa_kraju = $this->obrobkaNazwyKraju( $nazwa_kraju);

        $id_Kraju = $this->znajdzIdKraju( $nazwa_kraju );

        //sprawdz czy kraj o podanej nazwie istnieje
        if( $this->czyKrajIstnieje( $nazwa_kraju ) == false ){
            if ($json == "json_true") {
                return response()->json(['error' => 'kraj nie istnieje']);
            }
            else {
                return view('Kraj')->with('kraj', array() );
            }

        }


        if ($json == "json_true") { //zwroc dane w formie JSON
            return $this->zwrocDaneKrajuJSON( $id_Kraju );
        }
        else {  //wyswietl dane w formie strony HTML
            $kraj = $this->zwrocDaneKrajuHTML( $id_Kraju );
            return view('Kraj')->with('kraj', $kraj);
        }
    }


    /** 
    *funkcja zwraca Dane Kraju
    * @param string - nazwa kraju
    * @return - JSON zawierajacy dane kraju
    *
    */
    private function zwrocDaneKrajuJSON( $id_Kraju ) {

    	$daneKrajuJSON = $this->daneKrajuJSON( $id_Kraju );
        return $daneKrajuJSON;


    }


    /** 
    *funkcja zwraca Dane Kraju
    * @param string - nazwa kraju
    * @return - array($nazwa_kraju => $daneKraju), gdzie $daneKraju to tez array 
    *
    */
    private function zwrocDaneKrajuHTML( $id_Kraju ) {


        $daneKrajuJSON = $this->zwrocDaneKrajuJSON( $id_Kraju );

    	//utworz zmienna zawierajaca dane ktora zostanie zwrocona
    	$daneKraju = array();

    	//zmien pobrane dane kraju z bazy danych na zmienna gotowa do wyswietlania
    	//iteracja po kazdym elemencie zmiennej JSON zawierajacym dane kraju 
    	//odczytaj nazwe pola 
    	//zapisza w nowymm array $daneKraju nazwe pola i jego zawartosc
    	foreach ( $daneKrajuJSON as $dane ) {
     		$fieldid = $dane->fieldid;
    		$nazwaPola = $this->zwrocNazwePola( $fieldid );  
    		$value = $dane->value;
 
    		$daneKraju[ $nazwaPola ] = $value;
    	}


    	//utworz zwracana zmienna
      	$kraj = array(
   			$id_Kraju => $daneKraju
		);
		
		return $kraj; 	
    }

    /**
    * Znajdz id danego kraju podajac jego nazwe
    * @param - string - nazwa kraju - 
	* @return - number - countryid - Id Kraju lub NULL jesli nie ma danego kraju w bazie
    */
    private function znajdzIdKraju($nazwa_kraju) {
    	$krajBaza = \App\factbook_countries::where('name', $nazwa_kraju)->get();
        if( empty($krajBaza[0]) ) {
            return NULL;
        }
    	$countryid = $krajBaza[0]->id;
    	return $countryid;
    }


    /**
    *Funkcja zwraca dane/informacje pobrane z bazy danychna temat danego kraju
    * @param - int countryid
    * @return - JSON zawierajacy dane z bazy
    */
    private function daneKrajuJSON($countryid) {
        if( $countryid == NULL ){
            return NULL;
        }
    	$daneKraju = \App\factbook_values::where('countryid', $countryid)->get();
    	return $daneKraju;
    }


    /**
    *funkcja zwraca nazwe pola (pole zawiera pojedyncze dane na temat kraju np.: GDP, nazwa kraju ) 
    * @param int fieldid - id pola
    * @return - string, nazwa pola
    */
    private function zwrocNazwePola($fieldid) {
    	$nazwaPola = \App\factbook_fields::where('id', $fieldid)->get();
    	return $nazwaPola[0]->name;
    }


    /**
    *Sprawdz czy istniej kraj o podanej nazwie
    * @param - string nazwa kraju
    * @return - boolean - true jesli kraj o podanej nazwie istnieje, false jesli nie istnieje
    */
    private function czyKrajIstnieje( $nazwa_kraju ) {
        //odczytaj dane na temat danego kraju
        $countryid = $this->znajdzIdKraju( $nazwa_kraju );
        if( is_null( $countryid )) {
            return false;
        }

        return true;
    }

    /**
    * Zamien nazwe kraju na mozliwa do odczytania z bazy danych
    * @param - string - nazwa kraju
    * @return - string - nazwa kraju przystosowana do standartu w bazie danych
    */
    private function obrobkaNazwyKraju( $nazwa_kraju){
        //zamien podkreslniki na spacje
        $nazwa_kraju = ucwords( str_replace('_', ' ', $nazwa_kraju) );
        //zamien pierwsze male litery na wieksze
        // $nazwa_kraju = ucwords( $nazwa_kraju );

        return $nazwa_kraju;

    }


}
