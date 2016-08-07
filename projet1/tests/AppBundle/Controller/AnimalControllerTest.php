<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 13/07/16
 * Time: 16:08
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Country;
use PHPUnit\Framework\TestCase;

class AnimalControllerTest extends TestCase
{
    public function testNew()
    {
        $animal = new Animal();
        $animal->setName("Bear");
        $animal->setWeight(500);

        $this->assertEquals("Bear", $animal->getName());
        $this->assertEquals(500, $animal->getWeight());
    }

    public function testAddCountry()
    {
        $animal = new Animal();
        $country = new Country();
        $country->setName("France");

        $animal->addCountry($country);

        $countryExpected = $animal->getCountries()[0];
        $this->assertEquals("France", $countryExpected->getName());
    }

    public function testRemoveCountry()
    {
        $animal = new Animal();
        $country = new Country();
        $country->setName("France");

        $animal->addCountry($country);
        $animal->removeCountry($country);
        $this->assertEquals(0, count($animal->getCountries()));
    }
}