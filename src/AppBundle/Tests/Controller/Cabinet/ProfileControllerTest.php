<?php

namespace AppBundle\Tests\Controller\Cabinet;

use AppBundle\Tests\TestBase;

class ProfileControllerTest extends TestBase
{
    public function testNewCharity()
    {
        $client = static::createClient();
        $client->request('POST', '/charity-new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
