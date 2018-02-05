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

namespace Mcustiel\Phiremock\Server\Model\Implementation;

use Mcustiel\Phiremock\Server\Model\ScenarioStorage;

class ScenarioAutoStorage implements ScenarioStorage
{
    /**
     * @var string[]
     */
    private $scenarios;

    public function __construct()
    {
        $this->scenarios = [];
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ScenarioStorage::setScenarioState()
     */
    public function setScenarioState($name, $state)
    {
        $this->scenarios[$name] = $state;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ScenarioStorage::getScenarioState()
     */
    public function getScenarioState($name)
    {
        if (!isset($this->scenarios[$name])) {
            $this->scenarios[$name] = self::INITIAL_SCENARIO;
        }

        return $this->scenarios[$name];
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ScenarioStorage::clearScenarios()
     */
    public function clearScenarios()
    {
        $this->scenarios = [];
    }
}
