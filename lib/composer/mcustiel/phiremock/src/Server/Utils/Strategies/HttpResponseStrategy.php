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

use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Response;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ResponseInterface;

class HttpResponseStrategy extends AbstractResponse implements ResponseStrategyInterface
{
    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Utils\Strategies\ResponseStrategyInterface::createResponse()
     */
    public function createResponse(Expectation $expectation, TransactionData $transactionData)
    {
        $responseConfig = $expectation->getResponse();
        $httpResponse = $transactionData->getResponse();
        $httpResponse = $this->getResponseWithBody($responseConfig, $httpResponse);
        $httpResponse = $this->getResponseWithStatusCode($responseConfig, $httpResponse);
        $httpResponse = $this->getResponseWithHeaders($responseConfig, $httpResponse);
        $this->processDelay($responseConfig);

        return $httpResponse;
    }

    /**
     * @param Response          $responseConfig
     * @param ResponseInterface $httpResponse
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function getResponseWithBody(Response $responseConfig, ResponseInterface $httpResponse)
    {
        if ($responseConfig->getBody()) {
            $httpResponse = $httpResponse->withBody(new StringStream($responseConfig->getBody()));
        }

        return $httpResponse;
    }
}
