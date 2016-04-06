<?php

namespace AppBundle\Tests\Controller\Cabinet;

use AppBundle\Tests\TestBase;

class ProfileControllerTest extends TestBase
{
    public function testDeleteUser()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:User')
            ->findOneBy([])->getSlug();
        $client->request('DELETE', "/users/{$slug}/delete");
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\ProfileController::deleteUserAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testEditUser()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:User')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/users/{$slug}/edit");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Cabinet\ProfileController::editUserAction', $client->getRequest()->attributes->get('_controller'));
    }
}
