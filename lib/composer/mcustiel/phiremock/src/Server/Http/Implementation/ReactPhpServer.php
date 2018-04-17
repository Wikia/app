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

namespace Mcustiel\Phiremock\Server\Http\Implementation;

use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Server\Http\RequestHandlerInterface;
use Mcustiel\Phiremock\Server\Http\ServerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use React\EventLoop\Factory as EventLoop;
use React\Http\Response as ReactResponse;
use React\Http\Server as ReactServer;
use React\Promise\Promise;
use React\Socket\Server as ReactSocket;
use Zend\Diactoros\Response as PsrResponse;

class ReactPhpServer implements ServerInterface
{
    /**
     * @var \Mcustiel\Phiremock\Server\Http\RequestHandlerInterface
     */
    private $requestHandler;

    /**
     * @var \React\EventLoop\LoopInterface
     */
    private $loop;

    /**
     * @var \React\Socket\Server
     */
    private $socket;

    /**
     * @var \React\Http\Server
     */
    private $http;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->loop = EventLoop::create();
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Http\ServerInterface::setRequestHandler()
     */
    public function setRequestHandler(RequestHandlerInterface $handler)
    {
        $this->requestHandler = $handler;
    }

    /**
     * @param int    $port
     * @param string $host
     */
    public function listen($port, $host)
    {
        $this->http = new ReactServer(
            function (ServerRequestInterface $request) {
                return $this->createRequestManager($request);
            }
        );

        $this->logger->info("Phiremock http server listening on {$host}:{$port}");
        $this->socket = new ReactSocket("{$host}:{$port}", $this->loop);
        $this->http->listen($this->socket);

        // Dispatch pending signals periodically
        if (function_exists('pcntl_signal_dispatch')) {
            $this->loop->addPeriodicTimer(0.5, function () {
                pcntl_signal_dispatch();
            });
        }
        $this->loop->run();
    }

    public function shutdown()
    {
        $this->loop->stop();
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    private function onRequest(ServerRequestInterface $request)
    {
        $start = microtime(true);
        $psrResponse = $this->requestHandler->execute($request, new PsrResponse());
        $this->logger->debug('Processing took ' . number_format((microtime(true) - $start) * 1000, 3) . ' milliseconds');

        return $psrResponse;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return \React\Promise\Promise
     */
    private function createRequestManager(ServerRequestInterface $request)
    {
        return new Promise(function ($resolve, $reject) use ($request) {
            $bodyStream = '';

            $request->getBody()->on('data', function ($data) use (&$bodyStream, $request) {
                $bodyStream .= $data;
            });
            $request->getBody()->on('end', function () use ($resolve, $request, &$bodyStream) {
                $response = $this->onRequest($request->withBody(new StringStream($bodyStream)));
                $resolve($response);
            });
            $request->getBody()->on('error', function (\Exception $exception) use ($resolve) {
                $response = new ReactResponse(
                    400,
                    ['Content-Type' => 'text/plain'],
                    'An error occured while reading: ' . $exception->getMessage()
                );
                $resolve($response);
            });
        });
    }
}
