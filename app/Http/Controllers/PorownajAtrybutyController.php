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

    	$arrListaAtrybutow = json_decode($listaAtrybutow->content(), true);

        $colListaAtrybutow = collect($arrListaAtrybutow);

        $fieldids = $colListaAtrybutow->keys();

    	$daneKrajow = array();

        $daneKrajow["nazwaKrajow"] = [$nazwa_kraju1, $nazwa_kraju2];
        

        $colDanekraju1 = collect($daneKraju1);
        $colDanekraju2 = collect($daneKraju2);

        $colDanekraju1 = $colDanekraju1->keyBy("fieldid");
        $colDanekraju2 = $colDanekraju2->keyBy("fieldid");


        $colListaAtrybutow->each(function ($nazwaPola, $fieldid) use (&$daneKrajow, $colDanekraju1, $colDanekraju2)  {

            if ($colDanekraju1->has($fieldid) and $colDanekraju2->has($fieldid) ) {
                $daneKrajow["dane"][$nazwaPola] = array($colDanekraju1[$fieldid]["value"], $colDanekraju2[$fieldid]["value"] );    
            };
            
        });

        if ( $json_true == "json_true") {
            return response()->json($daneKrajow);
        } else {
            return view('porownanie_krajow')->with('daneKrajow', $daneKrajow );
        }



    	// dd( $nazwa_kraju1, $idKraju1, $daneKraju1, $nazwa_kraju2, $idKraju2, $daneKraju2);
    }
}
