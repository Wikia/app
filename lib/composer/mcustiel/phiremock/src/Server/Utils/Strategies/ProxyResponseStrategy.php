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

use Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Uri;

class ProxyResponseStrategy implements ResponseStrategyInterface
{
    /**
     * @var \Mcustiel\Phiremock\Common\Http\RemoteConnectionInterface
     */
    private $httpService;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param RemoteConnectionInterface $httpService
     * @param LoggerInterface           $logger
     */
    public function __construct(RemoteConnectionInterface $httpService, LoggerInterface $logger)
    {
        $this->httpService = $httpService;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Utils\Strategies\ResponseStrategyInterface::createResponse()
     */
    public function createResponse(Expectation $expectation, TransactionData $transactionData)
    {
        $url = $expectation->getProxyTo();
        $this->logger->debug('Proxying request to : ' . $url);

        return $this->httpService->send(
            $transactionData->getRequest()->withUri(new Uri($url))
        );
    }
}
