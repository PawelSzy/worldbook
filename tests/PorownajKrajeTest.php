<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PorownajKrajeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWyswietlPorownanieHTML()
    {
          $this->visit('/porownaj/germany/china')
             ->see("gdp")->see("Germany")->see("China");
    }

    public function testWyswietlPorownanieJSON()
    {
          $this->visit('/porownaj/germany/china/json_true')
             ->see("gdp")->see("Germany")->see("China");
    }

}
