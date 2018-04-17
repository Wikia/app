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

namespace Mcustiel\Phiremock\Server;

use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Server\Http\RequestHandlerInterface;
use Mcustiel\PowerRoute\PowerRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Phiremock implements RequestHandlerInterface
{
    /**
     * @var \Mcustiel\PowerRoute\PowerRoute
     */
    private $router;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param PowerRoute      $router
     * @param LoggerInterface $logger
     */
    public function __construct(PowerRoute $router, LoggerInterface $logger)
    {
        $this->router = $router;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Http\RequestHandlerInterface::execute()
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            return $this->router->start($request, $response);
        } catch (\Exception $e) {
            $this->logger->warning('Unexpected exception: ' . $e->getMessage());
            $this->logger->debug($e->__toString());

            return $response->withStatus(500)
                ->withBody(new StringStream($e->getMessage()));
        }
    }
}
