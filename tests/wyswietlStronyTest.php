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


    
    /**
    *Sprawdz czy pobiera i wyswietla dane z Bazy
    * @test
    */
    public function testWyswietlKrajzBazy()
    {
        $this->visit('kraj/Germany')
             ->see("Berlin");

        $this->visit('kraj/France')
             ->see("Paris");

        $this->visit('kraj/United Kingdom')
             ->see("London");
 
    }


    /**
    *Sprawdz czy pobiera i wyswietla dane z Bazy, w formacie JSON
    * @test
    */
    public function testWyswietlKrajzBazyJSON()
    {
        $this->visit('kraj/Germany/json_true')
             ->see("Berlin");

        $this->visit('kraj/France/json_true')
             ->see("Paris");

        $this->visit('kraj/United Kingdom/json_true')
             ->see("London");
 
    }


    /**
    *Sprawdz czy poprawnie wyswietla informacje o nieistnniejacym kraju
    * @test
    */
    public function testKrajNieIstnieje()
    {
        $this->visit('kraj/Nieistnieje')
             ->see("Nie znaleziono kraju");       
    }


    /**
    *Sprawdz czy wyswietla informacje ze kraj nie istnieje - format JSON
    */
    public function testKrajNieIstniejeJSON()
    {
        $this->visit('kraj/Nieistnieje/json_true')
             ->see("error");       
    }


    /**
    *Sprawdz czy zamienia male litery
    * @test
    */
    public function testWyswietlKrajMaleLitery()
    {
        $this->visit('kraj/germany')
             ->see("Berlin");

        $this->visit('kraj/france')
             ->see("Paris");

        $this->visit('kraj/united kingdom')
             ->see("London");
 
    }

    /**
    *Sprawdz czy zamienia podkreslniki na spacje
    * @test
    */
    public function test_WyswietlKraj_PodkreslnikiNaSpacje()
    {

        $this->visit('kraj/United_Kingdom')
             ->see("London");

         $this->visit('kraj/United_States')
             ->see("Washington, DC");            
 
    }

    /**
    *Sprawdz czy zamienia podkreslniki na spacje
    * i jednoczesnie male litery na duze
    * @test
    */
    public function testWyswietl_Podkreslniki_Litery()
    {
        $this->visit('kraj/united_kingdom')
             ->see("London");

        $this->visit('kraj/united_states')
             ->see("Washington, DC");

    }
}