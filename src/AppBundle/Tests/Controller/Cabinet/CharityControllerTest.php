<?php

namespace AppBundle\Tests\Controller\Cabinet;

use AppBundle\Tests\TestBase;

class CharityControllerTest extends TestBase
{
    public function testIndexCharity()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $client->request('GET', '/charity-manager/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\CharityController::indexCharityAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('GET', "/charity-manager/0");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [404]));
    }

    public function testShowCharity()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charity-manager/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\CharityController::showCharityAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('GET', "/charity-manager/vasia");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [500, 404]));
    }

    public function testNewCharity()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $client->request('POST', '/charity-new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\CharityController::newCharityAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('GET', "/charity-new");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [200]));
    }

    public function testDeleteCharity()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charities/{$slug}/delete");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\CharityController::deleteCharityAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testEditCharity()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charities/{$slug}/edit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\CharityController::editCharityAction', $client->getRequest()->attributes->get('_controller'));
    }
}
