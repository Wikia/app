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

namespace Mcustiel\Phiremock\Common\Utils;

class FileSystem
{
    /**
     * @param string $path
     *
     * @return mixed
     */
    public function getRealPath($path)
    {
        $existentPath = $this->normalizePath($path);
        $tail = [];

        $pathArray = explode('/', $existentPath);
        while (!file_exists($existentPath)) {
            array_unshift($tail, array_pop($pathArray));
            $existentPath = implode('/', $pathArray);
        }

        return str_replace(
            DIRECTORY_SEPARATOR,
            '/',
            $existentPath . '/' . implode(DIRECTORY_SEPARATOR, $tail)
        );
    }

    /**
     * @param string $path
     *
     * @return string|mixed
     */
    private function normalizePath($path)
    {
        $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        if ('/' !== $path[0]) {
            $path = getcwd() . '/' . $path;
        }

        return $path;
    }
}
