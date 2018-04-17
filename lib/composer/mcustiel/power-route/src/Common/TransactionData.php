<?php

namespace Mcustiel\PowerRoute\Common;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @codeCoverageIgnore
 */
class TransactionData
{
    private $values = [];

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $request;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Mcustiel\PowerRoute\Common\TransactionData
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Mcustiel\PowerRoute\Common\TransactionData
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function get($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }

    public function set($name, $value)
    {
        $this->values[$name] = $value;
    }
}
