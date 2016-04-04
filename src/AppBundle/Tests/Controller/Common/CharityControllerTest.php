<?php

namespace AppBundle\Tests\Controller\Common;

use AppBundle\Tests\TestBase;

class CharityControllerTest extends TestBase
{
    public function testIndexCharity()
    {
        $client = static::createClient();
        $client->request('GET', '/charities');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/charities');
        $heading = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('Запити', $heading);
        $this->assertEquals(1, $crawler->filter('h1')->count());

        $text2 = $crawler->filter('h3')->first()->text();
        $this->assertEquals("Найважливіші на думку спільноти запити", $text2);
    }

    public function testShowCharity()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $crawler = $client->request('GET', "/charities/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            1,
            $crawler->filter('h1')->count()
        );
    }

    public function testFindCharitiesForm()
    {
        $client = static::createClient();
        $client->request('POST', '/charities-find-form');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testFindCharitiesResults()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}
