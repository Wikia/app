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

namespace Mcustiel\Phiremock\Server\Utils;

class ArraysHelper
{
    /**
     * @param array $array
     *
     * @return bool
     */
    public static function isAssociative(array $array)
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return bool
     */
    public static function areRecursivelyEquals(array $array1, array $array2)
    {
        if (count($array1) !== count($array2)) {
            return false;
        }

        return self::arrayIsContained($array1, $array2);
    }

    /**
     * @param array $array1
     * @param array $array2
     *
     * @return bool
     */
    public static function arrayIsContained(array $array1, array $array2)
    {
        foreach ($array1 as $key => $value1) {
            if (!array_key_exists($key, $array2)) {
                return false;
            }
            if (!self::haveTheSameTypeAndValue($value1, $array2[$key])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function haveTheSameTypeAndValue($value1, $value2)
    {
        if (gettype($value1) !== gettype($value2)) {
            return false;
        }

        return self::haveTheSameValue($value1, $value2);
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return bool
     */
    public static function haveTheSameValue($value1, $value2)
    {
        if (is_array($value1)) {
            if (!self::areRecursivelyEquals($value1, $value2)) {
                return false;
            }
        } else {
            if ($value1 !== $value2) {
                return false;
            }
        }

        return true;
    }
}
