<?php

namespace EditeurBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editeur');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains("login", $client->getResponse()->getContent());
    }
}
