<?php

namespace Etk\Bundle\SFPBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class registroControllerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testAlta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/alta');
    }

    public function testBorrar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/borrar');
    }

    public function testModificar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modificar');
    }

}
