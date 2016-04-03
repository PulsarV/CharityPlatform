<?php

namespace AppBundle\Tests\Controller\Common;

use AppBundle\Tests\TestBase;

class CharityControllerTest extends TestBase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $client->request('GET', '/charities');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testHeadingHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/charities');
        $heading = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('Запити', $heading);
        $this->assertEquals(1, $crawler->filter('h1')->count());
    }

    public function testText()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/charities');

//        $this->assertTrue($crawler->filter('h3.widget top-requests')->count() > 0);

//        $text1 = $crawler->filter('h3.widget top-requests')->first()->text();
//        $this->assertEquals("Найважливіші на думку спільноти запити", $text1);

        $text2 = $crawler->filter('h3')->first()->text();
        $this->assertEquals("Найважливіші на думку спільноти запити", $text2);
    }
}
