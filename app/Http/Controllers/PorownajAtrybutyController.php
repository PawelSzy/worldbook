<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PorownajAtrybutyController extends CzytajDane
{
    public function wyswietlPorownanieKrajow( $nazwa_kraju1, $nazwa_kraju2, $json_true = null ) {
    	$listaAtrybutow = app('App\Http\Controllers\RankingiController')->wyswietlRankingi("json_true");


    	$nazwa_kraju1 = $this->obrobkaNazwyKraju( $nazwa_kraju1 );
    	$nazwa_kraju2 = $this->obrobkaNazwyKraju( $nazwa_kraju2 );

    	$idKraju1 = $this->znajdzIdKraju( $nazwa_kraju1 );
    	$idKraju2 = $this->znajdzIdKraju( $nazwa_kraju2 );


    	$daneKraju1 = $this->daneKrajuJSON( $idKraju1 );
    	$daneKraju2 = $this->daneKrajuJSON( $idKraju2 );

    	$listaAtrybutowArray = json_decode($listaAtrybutow->content(), true);

    	$daneKraju = array();

    	// //zmien pobrane dane kraju z bazy danych na zmienna gotowa do wyswietlania
    	// //iteracja po kazdym elemencie zmiennej JSON zawierajacym dane kraju 
    	// //odczytaj nazwe pola 
    	// //zapisza w nowymm array $daneKraju nazwe pola i jego zawartosc
    	// foreach ( $daneKrajuJSON as $dane ) {
     // 		$fieldid = $dane->fieldid;
    	// 	$nazwaPola = $this->zwrocNazwePola( $fieldid );  
    	// 	$value = $dane->value;
 
    	// 	$daneKraju[ $nazwaPola ] = $value;
    	// }


    	return response()->json($listaAtrybutowArray);


    	// dd( $nazwa_kraju1, $idKraju1, $daneKraju1, $nazwa_kraju2, $idKraju2, $daneKraju2);
    }
}
