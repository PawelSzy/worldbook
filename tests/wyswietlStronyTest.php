<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class wyswietlStronyTest extends TestCase
{

    /**
    *
    * @test
    *funkcja sprawdza czy Laravel wyswietla strone testowa - nie istniejacy kran angbar
    */
    public function testWyswietlStrone()
    {
        $this->visit('kraj/angbar')
             ->see("angbar")
             ->see('waluta')
             ->see('gdp')
             ->see(75767687876)
             ->see("Trzeciej Ery");
   
    }
}