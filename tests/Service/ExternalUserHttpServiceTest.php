<?php

namespace App\Tests\Service;

use App\Service\ExternalUserHttpService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ExternalUserHttpServiceTest extends TestCase
{
    public function testGetUserReturnsArray()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->method('toArray')->willReturn(['id' => 1, 'name' => 'Test']);
        $httpClient->method('request')->willReturn($response);

        $service = new ExternalUserHttpService($httpClient);
        $result = $service->getUser(1);

        $this->assertIsArray($result);
        $this->assertEquals(1, $result['id']);
    }
}