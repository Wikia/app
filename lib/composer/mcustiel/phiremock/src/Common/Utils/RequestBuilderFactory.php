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

use Mcustiel\SimpleRequest\ParserGenerator;
use Mcustiel\SimpleRequest\RequestBuilder as SimpleRequestBuilder;
use Mcustiel\SimpleRequest\Services\DoctrineAnnotationService;
use Mcustiel\SimpleRequest\Services\PhpReflectionService;
use Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory;
use Symfony\Component\Cache\Adapter\FilesystemAdapter as Psr6CacheAdapter;

class RequestBuilderFactory
{
    /**
     * @return \Mcustiel\SimpleRequest\RequestBuilder
     */
    public static function createRequestBuilder()
    {
        return new SimpleRequestBuilder(
            new Psr6CacheAdapter(
                'requests',
                3600,
                sys_get_temp_dir() . '/phiremock/cache/'
            ),
            new ParserGenerator(
                new DoctrineAnnotationService(),
                new AnnotationParserFactory(),
                new PhpReflectionService()
            )
        );
    }
}
