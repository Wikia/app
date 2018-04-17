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

class HomePathService
{
    /**
     * @throws \Exception
     *
     * @return string
     */
    public function getHomePath()
    {
        $unixHome = getenv('HOME');

        if (!empty($unixHome)) {
            return $unixHome;
        }

        $windowsHome = getenv('USERPROFILE');
        if (!empty($windowsHome)) {
            return $windowsHome;
        }

        $windowsHome = getenv('HOMEPATH');
        if (!empty($windowsHome)) {
            return getenv('HOMEDRIVE') . getenv('HOMEPATH');
        }

        throw new \Exception('Could not get the users\'s home path');
    }
}
