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

namespace Mcustiel\Phiremock\Client\Utils;

use Mcustiel\Phiremock\Domain\BinaryInfo;
use Mcustiel\Phiremock\Domain\Response;

class ResponseBuilder
{
    /**
     * @var \Mcustiel\Phiremock\Domain\Response
     */
    private $response;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $scenarioState;

    /**
     * @param int $statusCode
     */
    private function __construct($statusCode)
    {
        $this->response = new Response();
        $this->response->setStatusCode($statusCode);
    }

    /**
     * @param int $statusCode
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public static function create($statusCode)
    {
        return new static($statusCode);
    }

    /**
     * @param string $body
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andBody($body)
    {
        $this->response->setBody($body);

        return $this;
    }

    /**
     * @param string $body
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andBinaryBody($body)
    {
        $this->response->setBody(BinaryInfo::BINARY_BODY_PREFIX . base64_encode($body));

        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andHeader($header, $value)
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * @param int $delay
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andDelayInMillis($delay)
    {
        $this->response->setDelayMillis($delay);

        return $this;
    }

    /**
     * @param string $scenarioState
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andSetScenarioStateTo($scenarioState)
    {
        $this->scenarioState = $scenarioState;

        return $this;
    }

    /**
     * @return string[]|\Mcustiel\Phiremock\Domain\Response[]
     */
    public function build()
    {
        if (!empty($this->headers)) {
            $this->response->setHeaders($this->headers);
        }

        return [$this->scenarioState, $this->response];
    }
}
