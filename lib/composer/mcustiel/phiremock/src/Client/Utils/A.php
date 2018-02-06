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

namespace Mcustiel\Phiremock\Client\Utils;

class A
{
    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function getRequest()
    {
        return RequestBuilder::create('get');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function postRequest()
    {
        return RequestBuilder::create('post');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function putRequest()
    {
        return RequestBuilder::create('put');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function optionsRequest()
    {
        return RequestBuilder::create('options');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function headRequest()
    {
        return RequestBuilder::create('head');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function fetchRequest()
    {
        return RequestBuilder::create('fetch');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function deleteRequest()
    {
        return RequestBuilder::create('delete');
    }

    /**
     * @return \Mcustiel\Phiremock\Client\Utils\RequestBuilder
     */
    public static function patchRequest()
    {
        return RequestBuilder::create('patch');
    }
}
