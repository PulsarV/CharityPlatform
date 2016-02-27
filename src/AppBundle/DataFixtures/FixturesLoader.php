<?php
namespace AppBundle\DataFixtures\ORM;
use Hautelook\AliceBundle\Alice\DataFixtures\Fixtures\Loader as DataFixtureLoader;
class FixturesLoader extends DataFixtureLoader
{
    /**
     * Returns an array of file paths to fixtures
     *
     * @return array<string>
     */
    protected function getFixtures()
    {
        $env = $this->container->get('kernel')->getEnvironment();
        if ($env == 'test') {
            return [
                __DIR__ . '/test/charity.yml',
            ];
        }
        return [
            __DIR__ . '/dev/charity.yml',
        ];
    }
}