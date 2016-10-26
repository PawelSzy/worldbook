<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CzytajDane extends Controller
{
    /**
    * Zamien nazwe kraju na mozliwa do odczytania z bazy danych
    * @param - string - nazwa kraju
    * @return - string - nazwa kraju przystosowana do standartu w bazie danych
    */
    protected function obrobkaNazwyKraju( $nazwa_kraju){
        //zamien podkreslniki na spacje
        $nazwa_kraju = ucwords( str_replace('_', ' ', $nazwa_kraju) );
        //zamien pierwsze male litery na wieksze
        // $nazwa_kraju = ucwords( $nazwa_kraju );

        return $nazwa_kraju;

    }


    /**
    * Znajdz id danego kraju podajac jego nazwe
    * @param - string - nazwa kraju - 
    * @return - number - countryid - Id Kraju lub NULL jesli nie ma danego kraju w bazie
    */
    protected function znajdzIdKraju($nazwa_kraju) {
        $krajBaza = \App\factbook_countries::where('name', $nazwa_kraju)->get();
        if( empty($krajBaza[0]) ) {
            return NULL;
        }
        $countryid = $krajBaza[0]->id;
        return $countryid;
    }


    /**
    *Sprawdz czy istniej kraj o podanej nazwie
    * @param - string nazwa kraju
    * @return - boolean - true jesli kraj o podanej nazwie istnieje, false jesli nie istnieje
    */
    protected function czyKrajIstnieje( $nazwa_kraju ) {
        //odczytaj dane na temat danego kraju
        $countryid = $this->znajdzIdKraju( $nazwa_kraju );
        if( is_null( $countryid )) {
            return false;
        }

        return true;
    }


    /**
    *funkcja zwraca nazwe pola (pole zawiera pojedyncze dane na temat kraju np.: GDP, nazwa kraju ) 
    * @param int fieldid - id pola
    * @return - string, nazwa pola
    */
    protected function zwrocNazwePola($fieldid) {
        $nazwaPola = \App\factbook_fields::where('id', $fieldid)->get();
        return $nazwaPola[0]->name;
    }


}
