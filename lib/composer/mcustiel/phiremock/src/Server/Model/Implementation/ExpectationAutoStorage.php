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

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Server\Model\ExpectationStorage;

class ExpectationAutoStorage implements ExpectationStorage
{
    /**
     * @var \Mcustiel\Phiremock\Domain\Expectation[]
     */
    private $expectations;

    public function __construct()
    {
        $this->clearExpectations();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ExpectationStorage::addExpectation()
     */
    public function addExpectation(Expectation $expectation)
    {
        $this->expectations[] = $expectation;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ExpectationStorage::listExpectations()
     */
    public function listExpectations()
    {
        return $this->expectations;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\Phiremock\Server\Model\ExpectationStorage::clearExpectations()
     */
    public function clearExpectations()
    {
        $this->expectations = [];
    }
}
