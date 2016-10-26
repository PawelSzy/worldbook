<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RekordTest extends TestCase
{
    /**
    *Sprawdz czy pobiera i wyswietla dane z Bazy, w formacie JSON
    * @test
    */
    public function testWyswietlKrajzBazyJSON()
    {
        $this->visit('/dane/Poland/92/json_true')
             ->see("GDP")->see("513.9");
 
    }

    public function testWyswietlKrajzBazyHTML()
    {
        $this->visit('/dane/Poland/92')
             ->see("Poland")->see("GDP")->see("513.9");
 
    }

}
