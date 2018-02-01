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

namespace Mcustiel\Phiremock\Server\Utils\Strategies;

use Mcustiel\Phiremock\Domain\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class AbstractResponse
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Response $responseConfig
     */
    protected function processDelay(Response $responseConfig)
    {
        if ($responseConfig->getDelayMillis()) {
            $this->logger->debug(
                'Delaying the response for ' . $responseConfig->getDelayMillis() . ' milliseconds'
            );
            usleep($responseConfig->getDelayMillis() * 1000);
        }
    }

    /**
     * @param Response          $responseConfig
     * @param ResponseInterface $httpResponse
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function getResponseWithHeaders(Response $responseConfig, ResponseInterface $httpResponse)
    {
        if ($responseConfig->getHeaders()) {
            foreach ($responseConfig->getHeaders() as $name => $value) {
                $httpResponse = $httpResponse->withHeader($name, $value);
            }
        }

        return $httpResponse;
    }

    /**
     * @param Response          $responseConfig
     * @param ResponseInterface $httpResponse
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function getResponseWithStatusCode(Response $responseConfig, ResponseInterface $httpResponse)
    {
        if ($responseConfig->getStatusCode()) {
            $httpResponse = $httpResponse->withStatus($responseConfig->getStatusCode());
        }

        return $httpResponse;
    }
}
