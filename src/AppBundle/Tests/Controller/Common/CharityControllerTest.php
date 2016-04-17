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
        $this->assertEquals('Перелік запитів', $heading);
        $this->assertEquals(1, $crawler->filter('h1')->count());

        $text2 = $crawler->filter('h3')->first()->text();
        $this->assertEquals("Найважливіші на думку спільноти запити", $text2);
        $this->assertEquals('AppBundle\Controller\Common\CharityController::indexCharityAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('GET', "/charities/0");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [404]));
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
        $this->assertEquals('AppBundle\Controller\Common\CharityController::showCharityAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testFindCharitiesForm()
    {
        $client = static::createClient();
        $client->request('POST', '/charities-find-form');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Common\CharityController::findCharitiesFormAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('GET', "/charities-find-form");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [405]));
    }
}
