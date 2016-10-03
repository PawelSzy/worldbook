<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class czytajBazeTest extends TestCase
{
    /**
     * Sprawdz odczyt podstawowych danych z bazy
     *
     * @return void
     */
    public function testCzytajBaze()
    {
	    $this->seeInDatabase('factbook_countries', [
	        'name' => 'Poland'
	    ]);

	    $this->seeInDatabase('factbook_countries', [
	        'name' => 'Angola'
	    ]);

	    $this->seeInDatabase('factbook_countries', [
	        'name' => 'Germany'
	    ]);	  


    }

    public function testCzytajFactbook_countryaliases()
    {
	    $this->seeInDatabase('factbook_countryaliases', [
	        'alias' => 'Poland'
	    ]);

	    $this->seeInDatabase('factbook_countryaliases', [
	        'alias' => 'Angola'
	    ]);

	    $this->seeInDatabase('factbook_countryaliases', [
	        'alias' => 'Germany'
	    ]);	  


    }

    public function testNieMaKraju() 
    {
  	    $this->missingFromDatabase('factbook_countries', [
	        'name' => 'nie_istnieje'
	    ]);	    	
    }
}
