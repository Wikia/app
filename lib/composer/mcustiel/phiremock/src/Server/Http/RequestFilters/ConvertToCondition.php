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

namespace Mcustiel\Phiremock\Server\Http\RequestFilters;

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Server\Config\Matchers;
use Mcustiel\SimpleRequest\Exception\FilterErrorException;
use Mcustiel\SimpleRequest\Interfaces\FilterInterface;

class ConvertToCondition implements FilterInterface
{
    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\FilterInterface::filter()
     */
    public function filter($value)
    {
        if (null === $value) {
            return;
        }
        $this->checkValueIsValidOrThrowException($value);
        $matcher = key($value);
        $this->validateMatcherOrThrowException($matcher);
        $this->validateValueOrThrowException($value[$matcher]);

        return new Condition($matcher, $value[$matcher]);
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\Specificable::setSpecification()
     * @SuppressWarnings("unused")
     */
    public function setSpecification($specification = null)
    {
    }

    /**
     * @param mixed $value
     *
     * @throws FilterErrorException
     */
    private function validateValueOrThrowException($value)
    {
        if (null === $value) {
            throw new FilterErrorException('Condition value can not be null');
        }
    }

    /**
     * @param mixed $matcher
     *
     * @throws FilterErrorException
     */
    private function validateMatcherOrThrowException($matcher)
    {
        if (!$this->isValidCondition($matcher)) {
            throw new FilterErrorException('Invalid condition matcher specified: ' . $matcher);
        }
    }

    /**
     * @param mixed $matcherName
     *
     * @return bool
     */
    private function isValidCondition($matcherName)
    {
        return Matchers::EQUAL_TO === $matcherName
            || Matchers::MATCHES === $matcherName
            || Matchers::SAME_STRING === $matcherName
            || Matchers::CONTAINS === $matcherName;
    }

    /**
     * @param mixed $value
     *
     * @throws FilterErrorException
     */
    private function checkValueIsValidOrThrowException($value)
    {
        if (!is_array($value) || 1 !== count($value)) {
            throw new FilterErrorException(
                'Condition parsing failed for "'
                . var_export($value, true)
                . '", it should be something like: "isEqualTo" : "a value"'
            );
        }
    }
}
