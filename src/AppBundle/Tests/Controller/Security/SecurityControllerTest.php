<?php

namespace AppBundle\Tests\Controller\Security;

use AppBundle\Tests\TestBase;

class SecurityControllerTest extends TestBase
{
    public function testLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::loginAction', $client->getRequest()->attributes->get('_controller'));
        $text = $crawler->filter('h4')->first()->text();
        $this->assertEquals("Авторизація", $text);
        $this->assertEquals(1, $crawler->filter('h1')->count());
    }

    public function testRegistration()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registration');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::registrationAction', $client->getRequest()->attributes->get('_controller'));
        $client->request('POST', "/registration");
        $this->assertTrue(in_array($client->getResponse()->getStatusCode(), [200]));
        $text = $crawler->filter('h4')->first()->text();
        $this->assertEquals("Реєстрація нового користувача", $text);
        $this->assertEquals(1, $crawler->filter('h1')->count());
        $this->assertEquals(4, $crawler->filter('h4')->count());
    }

    public function testRegistrationComplete()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/complete-registration');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::registrationCompleteAction', $client->getRequest()->attributes->get('_controller'));
        $text = $crawler->filter('h4')->first()->text();
        $this->assertEquals("Реєстрація нового користувача", $text);
        $this->assertEquals(1, $crawler->filter('h1')->count());
    }

    public function testRegisterPerson()
    {
        $client = static::createClient();
        $client->request('GET', '/register-person');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::registerPersonAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testRegisterOrganization()
    {
        $client = static::createClient();
        $client->request('GET', '/register-organization');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::registerOrganizationAction', $client->getRequest()->attributes->get('_controller'));
    }

    public function testLogout()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShowProfile()
    {
        $client = static::createClient(array(), [
            'PHP_AUTH_USER' => 'user@charity.ua',
            'PHP_AUTH_PW' => 'user',
        ]);
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:User')
            ->findOneBy([])->getSlug();
        $client->request('GET', "/profile/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('AppBundle\Controller\Security\SecurityController::showProfileAction', $client->getRequest()->attributes->get('_controller'));
    }
}
