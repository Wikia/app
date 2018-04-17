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
namespace Mcustiel\SimpleRequest;

use Mcustiel\SimpleRequest\Exception\InvalidRequestException;
use Psr\Cache\CacheItemPoolInterface as PsrCache;

/**
 * Builds a request by parsing all the resulting object's annotations and running
 * obtained filters and validators against the request.
 *
 * @author mcustiel
 */
class RequestBuilder
{
    const RETURN_ALL_ERRORS_IN_EXCEPTION = '\Mcustiel\SimpleRequest\AllErrorsRequestParser';
    const THROW_EXCEPTION_ON_FIRST_ERROR = '\Mcustiel\SimpleRequest\FirstErrorRequestParser';

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache;
    /**
     * @var ParserGenerator
     */
    private $parserGenerator;


    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \Mcustiel\SimpleRequest\ParserGenerator $parserGenerator
     */
    public function __construct(
        PsrCache $cache,
        ParserGenerator $parserGenerator
    ) {
        $this->cache = $cache;
        $this->parserGenerator = $parserGenerator;
    }

    /**
     * Main method of this class. Used to convert a request to an object of a given class by
     * using a requestParser.
     *
     * @param array|\stdClass $request   The request to convert to an object.
     * @param string|array    $className The class of the object to which the request must be converted.
     * @param string          $behavior  The behaviour of the parser.
     */
    public function parseRequest(
        $request,
        $className,
        $behavior = self::THROW_EXCEPTION_ON_FIRST_ERROR
    ) {
        $isArray = is_array($className);
        $className = $this->getClassName($className, $isArray);
        $parserObject = $this->generateRequestParserObject($className, new $behavior);

        return $this->executeParsing(
            $this->sanitizeRequestOrThrowExceptionIfInvalid($request),
            $parserObject,
            $isArray
        );
    }

    /**
     * @param array         $request
     * @param RequestParser $parserObject
     * @param bool          $isArray
     *
     * @return object|object[]
     */
    private function executeParsing(array $request, RequestParser $parserObject, $isArray)
    {
        if ($isArray) {
            return $this->parseArray($request, $parserObject);
        }
        return $parserObject->parse($request);
    }

    /**
     * @param array         $request
     * @param RequestParser $parserObject
     */
    private function parseArray(array $request, RequestParser $parserObject)
    {
        $return = [];
        foreach ($request as $requestItem) {
            $return[] = $parserObject->parse($requestItem);
        }
        return $return;
    }

    /**
     * @param string|array $className
     * @param bool         $isArray
     *
     * @return string
     */
    private function getClassName($className, $isArray)
    {
        return '' . $isArray ? $className[0] : $className;
    }

    /**
     * @param string        $className
     * @param RequestParser $parser
     *
     * @return \Mcustiel\SimpleRequest\RequestParser|mixed
     */
    private function generateRequestParserObject($className, RequestParser $parser)
    {
        $cacheKey = str_replace('\\', '', $className . get_class($parser));
        $cacheItem = $this->cache->getItem($cacheKey);
        $return = $cacheItem->get();
        if ($return === null) {
            $return = $this->parserGenerator->populateRequestParser($className, $parser, $this);
            $cacheItem->set($return);
            $this->cache->save($cacheItem);
        }

        return $return;
    }

    /**
     * @param mixed $request
     *
     * @throws \Mcustiel\SimpleRequest\Exception\InvalidRequestException
     *
     * @return \stdClass|mixed
     */
    private function sanitizeRequestOrThrowExceptionIfInvalid($request)
    {
        $isObject = ($request instanceof \stdClass);
        if (!is_array($request) && !$isObject) {
            throw new InvalidRequestException(
                'Request builder is intended to be used with arrays or instances of \\stdClass'
            );
        }
        return $isObject ? json_decode(json_encode($request), true) : $request;
    }
}
