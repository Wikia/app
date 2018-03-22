<?php
/**
 * This file is part of php-simple-request.
 *
 * php-simple-request is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-request is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-request.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Mcustiel\SimpleRequest\Validator;

/**
 * Checks if a given string has hostname format.
 *
 * @author mcustiel
 */
class HostName extends RegExp
{
    const REGEXP = '/^[a-z0-9][a-z0-9\-_]{0,61}[a-z0-9](\.[a-z0-9\-_]{0,63})*\.[a-z]{2,6}$/i';

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\RegExp::setSpecification()
     */
    public function setSpecification($specification = null)
    {
        parent::setSpecification(self::REGEXP);
    }

    public function validate($value)
    {
        if (!is_string($value) || strlen($value) > 255) {
            return false;
        }
        return parent::validate($value);
    }
}
