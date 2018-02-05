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

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;

class RequestBuilder
{
    private $request;
    private $headers = [];
    private $scenarioName;
    private $scenarioIs;
    private $priority;

    private function __construct($method, $url = null)
    {
        $this->request = new Request();
        $this->request->setMethod($method);
        if (null !== $url) {
            $this->request->setUrl(new Condition('isEqualTo', $url));
        }
    }

    /**
     * @param string     $method
     * @param null|mixed $url
     *
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function create($method, $url = null)
    {
        return new static($method, $url);
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Condition $condition
     *
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public function andBody(Condition $condition)
    {
        $this->request->setBody($condition);

        return $this;
    }

    /**
     * @param string                               $header
     * @param \Mcustiel\Phiremock\Domain\Condition $condition
     *
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public function andHeader($header, Condition $condition)
    {
        $this->headers[$header] = $condition;

        return $this;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Condition $condition
     *
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public function andUrl(Condition $condition)
    {
        $this->request->setUrl($condition);

        return $this;
    }

    /**
     * @param string $scenario
     * @param string $scenarioState
     *
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public function andScenarioState($scenario, $scenarioState)
    {
        $this->scenarioName = $scenario;
        $this->scenarioIs = $scenarioState;

        return $this;
    }

    /**
     * @param int $priority
     */
    public function andPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function build()
    {
        if (!empty($this->headers)) {
            $this->request->setHeaders($this->headers);
        }
        $expectation = new Expectation();
        $expectation->setRequest($this->request);
        $this->setScenario($expectation);
        $this->setPriority($expectation);

        return $expectation;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Expectation $expectation
     */
    private function setPriority(Expectation $expectation)
    {
        if ($this->priority) {
            $expectation->setPriority((int) $this->priority);
        }
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Expectation $expectation
     */
    private function setScenario(Expectation $expectation)
    {
        if ($this->scenarioName && $this->scenarioIs) {
            $expectation->setScenarioName($this->scenarioName)
                ->setScenarioStateIs($this->scenarioIs);
        }
    }
}
