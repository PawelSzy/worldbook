<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RankingTest extends TestCase
{
    /**
    * Wyswietl Rankingi - po jakich elementach mozemy porownac kraje
    * @test
    */
    public function testWyswietlRankingi()
    {
        $this->visit('/rankingi/json_true')
             ->see("area")->see("Population")->see("Airports");
 
    }

    /**
    * Sprawdz rankingi - czy wyswietla sie odpowiedni ranking
    * @test
    */
    public function testWyswietlRanking()
    {
        $this->visit('/ranking/7/10/json_true')
             ->see("area")->see("Russia");
 
		$this->visit('/ranking/29/10/json_true')
             ->see("Population")->see("China");

    	$this->visit('/ranking/91/10/json_true')
             ->see("GDP")->see("States");
    }


}
