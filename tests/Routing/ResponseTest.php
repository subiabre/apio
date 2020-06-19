<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testDataAndErrorReturnSelf()
    {
        $response = new Response();

        $error = $response->error(['message' => 'error']);
        $data = $response->data(['body' => 'data']);

        $this->assertInstanceOf(Response::class, $error);
        $this->assertInstanceOf(Response::class, $data);
    }

    public function testResponseErrorComposesArray()
    {
        $response = new Response();
        
        $response->error(['message' => 'error message']);

        $error = \json_encode(['error' => [
            'message' => 'error message'
        ]]);

        $this->assertSame($error, $response->getContent());
    }

    public function testResponseDataComposesArray()
    {
        $response = new Response();
        
        $response->data(['body' => 'data body']);

        $data = \json_encode(['data' => [
            'body' => 'data body'
        ]]);

        $this->assertSame($data, $response->getContent());
    }
}
