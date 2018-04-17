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

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\SimpleRequest\Annotation\Filter as SRF;
use Mcustiel\SimpleRequest\Annotation\ParseAs;
use Mcustiel\SimpleRequest\Annotation\Validator as SRV;

class Expectation implements \JsonSerializable
{
    /**
     * @var Request
     *
     * @SRV\NotNull
     * @ParseAs("\Mcustiel\Phiremock\Domain\Request")
     */
    private $request;
    /**
     * @var Response
     *
     * @SRF\CustomFilter(class="\Mcustiel\Phiremock\Common\Filters\ResponseAsDefault")
     * @ParseAs("\Mcustiel\Phiremock\Domain\Response")
     */
    private $response;
    /**
     * @var string
     *
     * @SRV\OneOf({
     *      @SRV\Not(@SRV\NotEmpty),
     *      @SRV\Uri
     * })
     */
    private $proxyTo;
    /**
     * @var string
     *
     * @SRV\OneOf({
     *      @SRV\Type("null"),
     *      @SRV\AllOf({
     *          @SRV\Type("string"),
     *          @SRV\NotEmpty
     *      })
     * })
     */
    private $scenarioName;
    /**
     * @var string
     *
     * @SRV\OneOf({
     *      @SRV\Type("null"),
     *      @SRV\AllOf({
     *          @SRV\Type("string"),
     *          @SRV\NotEmpty
     *      })
     * })
     */
    private $scenarioStateIs;
    /**
     * @var string
     *
     * @SRV\OneOf({
     *      @SRV\Type("null"),
     *      @SRV\AllOf({
     *          @SRV\Type("string"),
     *          @SRV\NotEmpty
     *      })
     * })
     */
    private $newScenarioState;

    /**
     * @var int
     * @SRV\OneOf({
     *      @SRV\Type("null"),
     *      @SRV\AllOf({
     *          @SRV\TypeInteger,
     *          @SRV\Minimum(0)
     *      })
     * })
     */
    private $priority = 0;

    public function __toString()
    {
        return print_r(
            [
                'scenarioName'     => $this->scenarioName,
                'scenarioStateIs'  => $this->scenarioStateIs,
                'newScenarioState' => $this->newScenarioState,
                'request'          => isset($this->request) ? $this->request->__toString() : 'null',
                'response'         => isset($this->response) ? $this->response->__toString() : 'null',
                'proxyTo'          => $this->proxyTo,
                'priority'         => $this->priority,
            ], true
        );
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Request $request
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Response $response
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return string
     */
    public function getScenarioName()
    {
        return $this->scenarioName;
    }

    /**
     * @param string $scenario
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setScenarioName($scenario)
    {
        $this->scenarioName = $scenario;

        return $this;
    }

    /**
     * @return string
     */
    public function getScenarioStateIs()
    {
        return $this->scenarioStateIs;
    }

    /**
     * @param string $scenarioStateIs
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setScenarioStateIs($scenarioStateIs)
    {
        $this->scenarioStateIs = $scenarioStateIs;

        return $this;
    }

    /**
     * @return string
     */
    public function getNewScenarioState()
    {
        return $this->newScenarioState;
    }

    /**
     * @param string $newScenarioState
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setNewScenarioState($newScenarioState)
    {
        $this->newScenarioState = $newScenarioState;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getProxyTo()
    {
        return $this->proxyTo;
    }

    /**
     * @param string $proxyTo
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    public function setProxyTo($proxyTo)
    {
        $this->proxyTo = $proxyTo;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'scenarioName'     => $this->scenarioName,
            'scenarioStateIs'  => $this->scenarioStateIs,
            'newScenarioState' => $this->newScenarioState,
            'request'          => $this->request,
            'response'         => $this->response,
            'proxyTo'          => $this->proxyTo,
            'priority'         => $this->priority,
        ];
    }
}
