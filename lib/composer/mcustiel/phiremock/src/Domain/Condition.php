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

class Condition implements \JsonSerializable
{
    /**
     * @var string
     */
    private $matcher;
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string|null $matcher
     * @param mixed       $value
     */
    public function __construct($matcher = null, $value = null)
    {
        $this->matcher = $matcher;
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->matcher . ' ' . var_export($this->value, true);
    }

    /**
     * @return string
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param string $matcher
     *
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function setMatcher($matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [$this->matcher => $this->value];
    }
}
