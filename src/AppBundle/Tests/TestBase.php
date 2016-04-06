<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Entity\User;

class TestBase extends WebTestCase
{
    /** @var Client */
    protected $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->runCommand(['command' => 'doctrine:database:create']);
        $this->runCommand(['command' => 'doctrine:schema:update', '--force' => true]);
        $this->runCommand(['command' => 'hautelook_alice:doctrine:fixtures:load', '--no-interaction' => true]);
    }

    public function tearDown()
    {
        $this->runCommand(['command' => 'doctrine:database:drop', '--force' => true]);
        $this->client = null;
    }

    /**
     * @param array $arguments
     * @throws \Exception
     */
    protected function runCommand(array $arguments = [])
    {
        $application = new Application($this->client->getKernel());
        $application->setAutoExit(false);
        $arguments['--quiet'] = true;
        $arguments['-e'] = 'test';
        $input = new ArrayInput($arguments);
        $application->run($input, new ConsoleOutput());
    }

    /**
     * @param $role
     */
    protected function logIn($role)
    {
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $session = $this->client->getContainer()->get('session');
        $user = $em
            ->getRepository('AppBundle:User')
            ->findBy($role);
        $firewall = 'main';
        $token = new UsernamePasswordToken($user[0]->getUsername(), null, $firewall, array($role));
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}