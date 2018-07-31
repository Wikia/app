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
use Mcustiel\Phiremock\Server\Config\Matchers;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegexResponseStrategy extends AbstractResponse implements ResponseStrategyInterface
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
        $httpResponse = $this->getResponseWithBody(
            $expectation,
            $httpResponse,
            $transactionData->getRequest()
        );
        $httpResponse = $this->getResponseWithStatusCode($responseConfig, $httpResponse);
        $httpResponse = $this->getResponseWithHeaders($responseConfig, $httpResponse);
        $this->processDelay($responseConfig);

        return $httpResponse;
    }

    /**
     * @param Expectation            $expectation
     * @param ResponseInterface      $httpResponse
     * @param ServerRequestInterface $httpRequest
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function getResponseWithBody(
        Expectation $expectation,
        ResponseInterface $httpResponse,
        ServerRequestInterface $httpRequest
    ) {
        $responseBody = $expectation->getResponse()->getBody();

        if ($responseBody) {
            $responseBody = $this->fillWithUrlMatches($expectation, $httpRequest, $responseBody);
            $responseBody = $this->fillWithBodyMatches($expectation, $httpRequest, $responseBody);
            $httpResponse = $httpResponse->withBody(new StringStream($responseBody));
        }

        return $httpResponse;
    }

    /**
     * @param Expectation            $expectation
     * @param ServerRequestInterface $httpRequest
     * @param string                 $responseBody
     *
     * @return string
     */
    private function fillWithBodyMatches(Expectation $expectation, ServerRequestInterface $httpRequest, $responseBody)
    {
        if ($this->bodyConditionIsRegex($expectation)) {
            return $this->replaceMatches(
                'body',
                $expectation->getRequest()->getBody()->getValue(),
                $httpRequest->getBody()->__toString(),
                $responseBody
            );
        }

        return $responseBody;
    }

    /**
     * @param Expectation $expectation
     *
     * @return bool
     */
    private function bodyConditionIsRegex(Expectation $expectation)
    {
        return $expectation->getRequest()->getBody()
            && Matchers::MATCHES === $expectation->getRequest()->getBody()->getMatcher();
    }

    /**
     * @param Expectation            $expectation
     * @param ServerRequestInterface $httpRequest
     * @param string                 $responseBody
     *
     * @return string
     */
    private function fillWithUrlMatches(Expectation $expectation, ServerRequestInterface $httpRequest, $responseBody)
    {
        if ($this->urlConditionIsRegex($expectation)) {
            return $this->replaceMatches(
                'url',
                $expectation->getRequest()->getUrl()->getValue(),
                $this->getUri($httpRequest),
                $responseBody
            );
        }

        return $responseBody;
    }

    /**
     * @param ServerRequestInterface $httpRequest
     *
     * @return string
     */
    private function getUri(ServerRequestInterface $httpRequest)
    {
        $path = ltrim($httpRequest->getUri()->getPath(), '/');
        $query = $httpRequest->getUri()->getQuery();
        $return = '/' . $path;
        if ($query) {
            $return .= '?' . $httpRequest->getUri()->getQuery();
        }

        return $return;
    }

    /**
     * @param Expectation $expectation
     *
     * @return bool
     */
    private function urlConditionIsRegex(Expectation $expectation)
    {
        return $expectation->getRequest()->getUrl() && Matchers::MATCHES === $expectation->getRequest()->getUrl()->getMatcher();
    }

    /**
     * @param string $type
     * @param string $pattern
     * @param string $subject
     * @param string $responseBody
     *
     * @return string
     */
    private function replaceMatches($type, $pattern, $subject, $responseBody)
    {
        $matches = [];

        $matchCount = preg_match_all(
            $pattern,
            $subject,
            $matches
        );

        if ($matchCount > 0) {
            // we don't need full matches
            unset($matches[0]);
            $responseBody = $this->replaceMatchesInBody($matches, $type, $responseBody);
        }

        return $responseBody;
    }

    /**
     * @param array  $matches
     * @param string $type
     * @param string $responseBody
     *
     * @return string
     */
    private function replaceMatchesInBody(array $matches, $type, $responseBody)
    {
        $search = [];
        $replace = [];

        foreach ($matches as $matchGroupId => $matchGroup) {
            // add first element as replacement for $(type.index)
            $search[] = "\${{$type}.{$matchGroupId}}";
            $replace[] = reset($matchGroup);
            foreach ($matchGroup as $matchId => $match) {
                // fix index to start with 1 instead of 0
                ++$matchId;
                $search[] = "\${{$type}.{$matchGroupId}.{$matchId}}";
                $replace[] = $match;
            }
        }

        return str_replace($search, $replace, $responseBody);
    }
}
