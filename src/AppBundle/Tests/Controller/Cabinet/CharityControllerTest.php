<?php

namespace AppBundle\Tests\Controller\Cabinet;

use AppBundle\Tests\TestBase;

class CharityControllerTest extends TestBase
{
    public function testIndexCharity()
    {
        $client = static::createClient();
        $client->request('GET', '/charity-manager/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowCharity()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charity-manager/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testNewCharity()
    {
        $client = static::createClient();
        $client->request('POST', '/charity-new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testDeleteCharity()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charities/{$slug}/delete");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEditCharity()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Charity')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/charities/{$slug}/edit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
