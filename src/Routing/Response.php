<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Wraps the Symfony JsonResponse and provides nice methods
 */
class Response extends JsonResponse
{
    public const NOT_FOUND_MESSAGE = ['message' => 'Route not found.'];

    public const METHOD_NOT_ALLOWED_MESSAGE = ['message' => 'Method not allowed.'];
    
    private $errorArray = [];

    private $dataArray = [];

    /**
     * Set error data for the response
     * @param array $error Error data
     * @param int $status HTTP status code
     */
    public function error(array $data, int $status = 400)
    {
        $this->errorArray = \array_merge($this->errorArray, $data);
        
        $this->setData(['error' => $this->errorArray]);
        $this->setStatusCode($status);
    }

    /**
     * Set data body for the response
     * @param $data Data body
     * @param int $status HTTP status code
     */
    public function data($data, int $status = 200)
    {
        $this->dataArray = \array_merge($this->dataArray, $data);

        $this->setData(['data' => $this->dataArray]);
        $this->setStatusCode($status);
    }
} 
