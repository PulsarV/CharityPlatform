<?php

namespace AppBundle\Tests\Controller\Security;

use AppBundle\Tests\TestBase;

class SecurityControllerTest extends TestBase
{
    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegisterPerson()
    {
        $client = static::createClient();
        $client->request('GET', '/register-person');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegisterOrganization()
    {
        $client = static::createClient();
        $client->request('GET', '/register-organization');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testLogout()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW'   => 'user',
        ]);
        $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShowProfile()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW'   => 'user',
        ]);
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:User')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/profile/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
