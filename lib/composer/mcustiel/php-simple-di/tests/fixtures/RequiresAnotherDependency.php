<?php
/**
 * This file is part of php-simple-di.
 *
 * php-simple-di is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-di is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-di.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Fixtures;

use Mcustiel\DependencyInjection\Annotation\Inject;

/**
 * @codeCoverageIgnore
 */
class RequiresAnotherDependency
{
    private $fakeDependency;

    private $anotherDependency;

    public function __construct(FakeDependency $fakeDependency,
        AnotherDependency $anotherDependency)
    {
        $this->fakeDependency = $fakeDependency;
        $this->anotherDependency = $anotherDependency;
    }

    public function getFakeDependency()
    {
        return $this->fakeDependency;
    }

    public function setFakeDependency($fakeDependency)
    {
        $this->fakeDependency = $fakeDependency;
        return $this;
    }

    public function getAnotherDependency()
    {
        return $this->anotherDependency;
    }

    public function setAnotherDependency($anotherDependency)
    {
        $this->anotherDependency = $anotherDependency;
        return $this;
    }
}