<?php
/**
 * This file is part of mockable-datetime.
 *
 * mockable-datetime is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mockable-datetime is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with mockable-datetime.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Mcustiel\Mockable;

class DateTime
{
    private $type;
    private $timestamp;

    private $constructTime;

    public function __construct()
    {
        $this->constructTime = (new \DateTime())->getTimestamp();
        $this->type = DateTimeUtils::getType();
        $this->timestamp = DateTimeUtils::getTimestamp();
    }

    public function toPhpDateTime()
    {
        if ($this->type === DateTimeUtils::DATETIME_SYSTEM) {
            return new \DateTime('now');
        } elseif ($this->type === DateTimeUtils::DATETIME_FIXED) {
            return $this->createPhpDateWithTimestamp($this->timestamp);
        }

        return $this->createPhpDateWithTimestamp(
            $this->timestamp + abs(
                (new \DateTime('now'))->getTimestamp() - $this->constructTime
            )
        );
    }

    private function createPhpDateWithTimestamp($timestamp)
    {
        return new \DateTime("@$timestamp");
    }
}
