<?php

namespace AppBundle\Tests\Controller\Common;

use AppBundle\Tests\TestBase;

class IndexControllerTest extends TestBase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Common\IndexController::indexAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testIndexCharity()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/charities');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(
            1,
            $crawler->filter('h1')
        );
        $this->assertEquals('AppBundle\Controller\Common\CharityController::indexCharityAction', $client->getRequest()->attributes->get('_controller'));
    }
}