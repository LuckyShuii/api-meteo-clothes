<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClotheControllerTest extends WebTestCase
{
    /**
     * Test that the /clothe endpoint returns a successful response with the expected JSON structure.
     * It simulates a request to the endpoint with a valid city and checks the response.
     */
    public function testClotheEndpointReturnsSuccess()
    {
        // Create a client to simulate the request
        $client = static::createClient();

        // Simulate a request to the /clothe endpoint with a valid city
        $client->request('GET', '/clothe/paris');

        // Assert that the response is successful and in JSON format
        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        // Decode the JSON response and check its structure
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('products', $data);
        $this->assertArrayHasKey('weather', $data);
        $this->assertArrayHasKey('city', $data['weather']);
        $this->assertArrayHasKey('is', $data['weather']);
        $this->assertArrayHasKey('date', $data['weather']);
    }

    /**
     * Test that the /clothe endpoint returns a 400 Bad Request response when an unknown city is provided.
     * It simulates a request to the endpoint with an invalid city and checks the response.
     */
    public function testClotheEndpointFailsOnUnknownCity()
    {
        // Create a client to simulate the request
        $client = static::createClient();

        // Simulate a request to the /clothe endpoint with an unknown city
        $client->request('GET', '/clothe/unknownCity');

        // Assert that the response status code is 400 Bad Request
        $this->assertResponseStatusCodeSame(400);

        // Decode the JSON response and check for an error key
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $data);
    }

    /**
     * Test that the /clothe endpoint with ?date=tomorrow returns a successful response
     */
    public function testClotheEndpointWithTomorrowDate()
    {
        $client = static::createClient();
        $client->request('GET', '/clothe/paris?date=tomorrow');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $data = json_decode($client->getResponse()->getContent(), true);

        // Vérifie que la clé "weather"."date" vaut "tomorrow"
        $this->assertEquals('tomorrow', $data['weather']['date']);

        // On s'assure quand même que le reste de la structure est OK
        $this->assertArrayHasKey('products', $data);
        $this->assertArrayHasKey('weather', $data);
        $this->assertArrayHasKey('city', $data['weather']);
        $this->assertArrayHasKey('is', $data['weather']);
    }

    /**
     * Test that the /clothe endpoint fails with a 400 Bad Request response when an invalid date is provided.
     */
    public function testClotheEndpointFailsOnInvalidDate()
    {
        $client = static::createClient();
        $client->request('GET', '/clothe/paris?date=unknownDate');

        $this->assertResponseStatusCodeSame(400);

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('error', $data);
    }
}
