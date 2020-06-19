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
     * @return self
     */
    public function error(array $data, int $status = 400): self
    {
        $this->errorArray = \array_merge($this->errorArray, $data);
        
        $this->setData(['error' => $this->errorArray]);
        $this->setStatusCode($status);

        return $this;
    }

    /**
     * Set data body for the response
     * @param array $data Data body
     * @param int $status HTTP status code
     * @return self
     */
    public function data(array $data, int $status = 200): self
    {
        $this->dataArray = \array_merge($this->dataArray, $data);

        $this->setData(['data' => $this->dataArray]);
        $this->setStatusCode($status);

        return $this;
    }
} 
