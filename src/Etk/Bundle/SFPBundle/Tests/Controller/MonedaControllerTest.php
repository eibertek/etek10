<?php

namespace Etk\Bundle\SFPBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MonedaControllerTest extends WebTestCase
{
    public function testAlta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/alta');
    }

    public function testBaja()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/baja');
    }

    public function testListar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listar');
    }

}
