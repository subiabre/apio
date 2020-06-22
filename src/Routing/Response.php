<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Wraps the Symfony JsonResponse into a handy Response object
 */
class Response extends JsonResponse
{
    protected $bodyError = [];

    protected $bodyData = [];

    /**
     * Set error response body
     * @param array $body
     * @param int $status
     * @return self
     */
    public function error(array $body, int $status = 400): self
    {
        $this->bodyError = \array_merge($this->bodyError, $body);

        $this->setData(['error' => $this->bodyError]);
        $this->setStatusCode($status);

        return $this;
    }

    /**
     * Set data response body
     * @param array $body
     * @param int $status
     * @return self
     */
    public function data(array $body, int $status = 200): self
    {
        $this->bodyData = \array_merge($this->bodyData, $body);

        $this->setData(['data' => $this->bodyData]);
        $this->setStatusCode($status);

        return $this;
    }
}
