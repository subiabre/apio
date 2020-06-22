<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testErrorIsChainable()
    {
        $response = new Response;

        $error = $response->error(['key' => 'value']);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $error);
    }

    public function testDataIsChainable()
    {
        $response = new Response;

        $data = $response->data(['key' => 'value']);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $data);
    }

    public function testPushesDataIntoArrays()
    {
        $response = new Response;

        $response
            ->data(['body' => 'data'])
            ->data(['et' => 'al'])
            ;

        $expected = \json_encode(['data' => [
            'body' => 'data',
            'et' => 'al'
        ]]);

        $actual = $response->getContent();

        $this->assertSame($expected, $actual);
    }
}
