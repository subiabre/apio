<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
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
