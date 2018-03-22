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

namespace Mcustiel\Phiremock\Server\Http\ResponseFilters;

use Mcustiel\Phiremock\Domain\BinaryInfo;
use Mcustiel\SimpleRequest\Interfaces\FilterInterface;

class Base64BodyToString implements FilterInterface
{
    const STRING_START = 0;

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\Specificable::setSpecification()
     */
    public function setSpecification($specification = null)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\FilterInterface::filter()
     */
    public function filter($value)
    {
        if ($this->isBinary($value)) {
            return base64_decode(substr($value, BinaryInfo::BINARY_BODY_PREFIX_LENGTH), true);
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isBinary($value)
    {
        return BinaryInfo::BINARY_BODY_PREFIX === substr($value, self::STRING_START, BinaryInfo::BINARY_BODY_PREFIX_LENGTH);
    }
}
