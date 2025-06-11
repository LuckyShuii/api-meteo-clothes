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
}
