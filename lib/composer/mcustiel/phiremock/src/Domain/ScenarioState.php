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

use Mcustiel\SimpleRequest\Annotation\Validator as SRV;

class ScenarioState implements \JsonSerializable
{
    /**
     * @var string
     *
     * @SRV\AllOf({
     *     @SRV\Type("string"),
     *     @SRV\NotEmpty
     * })
     */
    private $scenarioName;

    /**
     * @var string
     *
     * @SRV\AllOf({
     *     @SRV\Type("string"),
     *     @SRV\NotEmpty
     * })
     */
    private $scenarioState;

    /**
     * @param string $name
     * @param string $state
     */
    public function __construct($name = '', $state = '')
    {
        $this->scenarioName = $name;
        $this->scenarioState = $state;
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
     * @return \Mcustiel\Phiremock\Domain\ScenarioState
     */
    public function setScenarioName($scenario)
    {
        $this->scenarioName = $scenario;

        return $this;
    }

    /**
     * @return string
     */
    public function getScenarioState()
    {
        return $this->scenarioState;
    }

    /**
     * @param string $scenarioState
     *
     * @return \Mcustiel\Phiremock\Domain\ScenarioState
     */
    public function setScenarioState($scenarioState)
    {
        $this->scenarioState = $scenarioState;

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
            'scenarioName'   => $this->scenarioName,
            'scenarioState'  => $this->scenarioState,
        ];
    }
}
