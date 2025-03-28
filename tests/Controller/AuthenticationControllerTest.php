<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationControllerTest extends WebTestCase
{
    #Hello
    public function testLoginSuccess(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'testuser@unit.com',
            'password' => 'password123',
        ]));

        $responseContent = $client->getResponse()->getContent();
        echo "Response: " . $responseContent;

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseData = json_decode($responseContent, true);

        $this->assertArrayHasKey('token', $responseData);
    }
}