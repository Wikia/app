<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock\Client;

use Mcustiel\Phiremock\Client\Utils\ExpectationBuilder;
use Mcustiel\Phiremock\Client\Utils\RequestBuilder;
use Mcustiel\Phiremock\Common\Http\Implementation\GuzzleConnection;
use Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface;
use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Common\Utils\RequestBuilderFactory;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\Phiremock\Domain\ScenarioState;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Request as PsrRequest;
use Zend\Diactoros\Uri;

class Phiremock
{
    const API_EXPECTATIONS_URL = '/__phiremock/expectations';
    const API_EXECUTIONS_URL = '/__phiremock/executions';
    const API_SCENARIOS_URL = '/__phiremock/scenarios';
    const API_RESET_URL = '/__phiremock/reset';
    const CLIENT_CONFIG = [
        'http_errors' => false,
    ];

    /**
     * @var \Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface
     */
    private $connection;
    /**
     * @var \Mcustiel\SimpleRequest\RequestBuilder
     */
    private $simpleRequestBuilder;
    /**
     * @var string
     */
    private $host;
    /**
     * @var int
     */
    private $port;

    /**
     * @param string                    $host
     * @param int                       $port
     * @param RemoteConnectionInterface $remoteConnection
     */
    public function __construct(
        $host = 'localhost',
        $port = 8080,
        RemoteConnectionInterface $remoteConnection = null
    ) {
        if (!$remoteConnection) {
            $remoteConnection = new GuzzleConnection(
                new \GuzzleHttp\Client(self::CLIENT_CONFIG)
            );
        }
        $this->host = $host;
        $this->port = $port;
        $this->connection = $remoteConnection;
    }

    /**
     * Creates an expectation with a response for a given request.
     *
     * @param \Mcustiel\Phiremock\Domain\Expectation $expectation
     */
    public function createExpectation(Expectation $expectation)
    {
        $uri = $this->createBaseUri()->withPath(self::API_EXPECTATIONS_URL);
        $body = @json_encode($expectation);
        if (false === $body) {
            throw new \RuntimeException('Error generating json body for request: ' . json_last_error_msg());
        }
        $request = (new PsrRequest())
            ->withUri($uri)
            ->withMethod('post')
            ->withHeader('Content-Type', 'application/json')
            ->withBody(new StringStream($body));
        $this->checkResponse($this->connection->send($request));
    }

    /**
     * Restores pre-defined expectations and resets scenarios and requests counter.
     */
    public function reset()
    {
        $uri = $this->createBaseUri()->withPath(self::API_RESET_URL);
        $request = (new PsrRequest())->withUri($uri)->withMethod('post');

        $this->checkResponse($this->connection->send($request));
    }

    /**
     * Clears all the currently configured expectations.
     */
    public function clearExpectations()
    {
        $uri = $this->createBaseUri()->withPath(self::API_EXPECTATIONS_URL);
        $request = (new PsrRequest())->withUri($uri)->withMethod('delete');

        $this->checkResponse($this->connection->send($request));
    }

    /**
     * Lists all currently configured expectations.
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation[]
     */
    public function listExpectations()
    {
        $uri = $this->createBaseUri()->withPath(self::API_EXPECTATIONS_URL);
        $request = (new PsrRequest())->withUri($uri)->withMethod('get');
        $response = $this->connection->send($request);

        if (200 === $response->getStatusCode()) {
            $builder = $this->getRequestBuilder();

            return $builder->parseRequest(
                json_decode($response->getBody()->__toString(), true),
                [Expectation::class]
            );
        }

        $this->checkErrorResponse($response);
    }

    /**
     * Counts the amount of times a request was executed in phiremock.
     *
     * @param \Mcustiel\Phiremock\Client\Utils\RequestBuilder $requestBuilder
     *
     * @return int
     */
    public function countExecutions(RequestBuilder $requestBuilder)
    {
        $expectation = $requestBuilder->build();
        $expectation->setResponse(new Response());
        $uri = $this->createBaseUri()->withPath(self::API_EXECUTIONS_URL);

        $request = (new PsrRequest())
            ->withUri($uri)
            ->withMethod('post')
            ->withHeader('Content-Type', 'application/json')
            ->withBody(new StringStream(json_encode($expectation)));

        $response = $this->connection->send($request);

        if (200 === $response->getStatusCode()) {
            $json = json_decode($response->getBody()->__toString());

            return $json->count;
        }

        $this->checkErrorResponse($response);
    }

    /**
     * List requests was executed in phiremock.
     *
     * @param \Mcustiel\Phiremock\Client\Utils\RequestBuilder $requestBuilder
     *
     * @return array
     */
    public function listExecutions(RequestBuilder $requestBuilder)
    {
        $expectation = $requestBuilder->build();
        $expectation->setResponse(new Response());
        $uri = $this->createBaseUri()->withPath(self::API_EXECUTIONS_URL);

        $request = (new PsrRequest())
            ->withUri($uri)
            ->withMethod('put')
            ->withHeader('Content-Type', 'application/json')
            ->withBody(new StringStream(json_encode($expectation)));

        $response = $this->connection->send($request);

        if (200 === $response->getStatusCode()) {
            return json_decode($response->getBody()->__toString());
        }

        $this->checkErrorResponse($response);
    }

    /**
     * Sets scenario state.
     *
     * @param \Mcustiel\Phiremock\Domain\ScenarioState $scenarioState
     */
    public function setScenarioState(ScenarioState $scenarioState)
    {
        $uri = $this->createBaseUri()->withPath(self::API_SCENARIOS_URL);
        $request = (new PsrRequest())
            ->withUri($uri)
            ->withMethod('put')
            ->withHeader('Content-Type', 'application/json')
            ->withBody(new StringStream(json_encode($scenarioState)));

        $response = $this->connection->send($request);
        if (200 !== $response->getStatusCode()) {
            $this->checkErrorResponse($response);
        }
    }

    /**
     * Resets all the scenarios to start state.
     */
    public function resetScenarios()
    {
        $uri = $this->createBaseUri()->withPath(self::API_SCENARIOS_URL);
        $request = (new PsrRequest())->withUri($uri)->withMethod('delete');

        $this->checkResponse($this->connection->send($request));
    }

    /**
     * Resets all the requests counters to 0.
     */
    public function resetRequestsCounter()
    {
        $uri = $this->createBaseUri()->withPath(self::API_EXECUTIONS_URL);
        $request = (new PsrRequest())->withUri($uri)->withMethod('delete');

        $this->checkResponse($this->connection->send($request));
    }

    /**
     * Inits the fluent interface to create an expectation.
     *
     * @param \Mcustiel\Phiremock\Client\Utils\RequestBuilder $requestBuilder
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ExpectationBuilder
     */
    public static function on(RequestBuilder $requestBuilder)
    {
        return new ExpectationBuilder($requestBuilder);
    }

    /**
     * Shortcut.
     *
     * @param string $method
     * @param string $url
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ExpectationBuilder
     */
    public static function onRequest($method, $url)
    {
        return new ExpectationBuilder(
            RequestBuilder::create($method, $url)
        );
    }

    /**
     * @return \Zend\Diactoros\Uri
     */
    private function createBaseUri()
    {
        return (new Uri())
            ->withScheme('http')
            ->withHost($this->host)
            ->withPort($this->port);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    private function checkResponse(ResponseInterface $response)
    {
        if (201 === $response->getStatusCode()) {
            return;
        }

        $this->checkErrorResponse($response);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \RuntimeException
     */
    private function checkErrorResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() >= 500) {
            $errors = json_decode($response->getBody()->__toString(), true)['details'];

            throw new \RuntimeException(
                'An error occurred creating the expectation: '
                . ($errors ? var_export($errors, true) : '')
                . $response->getBody()->__toString());
        }

        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('Request error while creating the expectation');
        }
    }

    /**
     * @return \Mcustiel\SimpleRequest\RequestBuilder
     */
    private function getRequestBuilder()
    {
        if (null === $this->simpleRequestBuilder) {
            $this->simpleRequestBuilder = RequestBuilderFactory::createRequestBuilder();
        }

        return $this->simpleRequestBuilder;
    }
}
