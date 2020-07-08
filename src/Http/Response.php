<?php declare(strict_types=1);

namespace Apio\Http;

use Amp\Http\Message;
use Amp\Http\Server\Response as ServerResponse;

/**
 * Wraps the Amp Response into a handy, json-ready Response object
 */
class Response
{
    /**
     * @var array
     */
    protected $bodyError = [];

    /**
     * @var array
     */
    protected $bodyData = [];

    /**
     * @var ServerResponse
     */
    protected $serverResponse;

    public function __construct(Message $serverResponse = NULL)
    {
        $jsonResponse = new ServerResponse(200, ['Content-Type' => 'application/json']);

        $this->serverResponse = $serverResponse ? $serverResponse : $jsonResponse;
    }

    /**
     * Set error response body
     * @param array $body
     * @param int $status
     * @return self
     */
    public function error(array $body, int $status = 400): self
    {
        $this->bodyError = \array_merge($this->bodyError, $body);

        $body = ['error' => $this->bodyError];

        $this->serverResponse->setBody(\json_encode($body));
        $this->serverResponse->setStatus($status);

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

        $body = ['data' => $this->bodyData];

        $this->serverResponse->setBody(\json_encode($body));
        $this->serverResponse->setStatus($status);

        return $this;
    }

    /**
     * Get the response status code
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->serverResponse->getStatus();
    }

    /**
     * Get the response body content
     * @return array
     */
    public function getData(): array
    {
        return ['data' => $this->bodyData];
    }

    /**
     * Get the response error content
     * @return array
     */
    public function getError(): array
    {
        return ['error' => $this->bodyError];
    }

    /**
     * Obtain the Amp Response object with the loaded data
     * @return ServerResponse
     */
    public function send(): ServerResponse
    {
        return $this->serverResponse;
    }
}
