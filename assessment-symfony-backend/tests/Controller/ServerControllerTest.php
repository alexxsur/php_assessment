<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServerControllerTest extends WebTestCase
{
    public function testListAction()
    {
        // Create a Symfony test client
        $client = static::createClient();

        // Send a GET request to the /server route
        $client->request('GET', '/server');

        // Assert a successful response (HTTP status code 200)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Assert that the response content is JSON
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testGetServerLocationsAction()
    {
        // Create a Symfony test client
        $client = static::createClient();

        // Send a GET request to the /server/locations route
        $client->request('GET', '/server/locations');

        // Assert a successful response (HTTP status code 200)
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Assert that the response content is JSON
        $this->assertJson($client->getResponse()->getContent());
    }
}