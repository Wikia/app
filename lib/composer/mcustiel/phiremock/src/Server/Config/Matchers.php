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

namespace Mcustiel\Phiremock\Server\Config;

class Matchers
{
    const MATCHES = 'matches';
    const EQUAL_TO = 'isEqualTo';
    const SAME_STRING = 'isSameString';
    const CONTAINS = 'contains';
    const SAME_JSON = 'isSameJsonObject';

    const VALID_MATCHERS = [
        self::CONTAINS,
        self::EQUAL_TO,
        self::MATCHES,
        self::SAME_JSON,
        self::SAME_STRING,
    ];

    /**
     * @param string $matcherName
     *
     * @return bool
     */
    public static function isValidMatcher($matcherName)
    {
        return in_array($matcherName, self::VALID_MATCHERS, true);
    }
}
