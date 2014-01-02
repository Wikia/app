<?php

namespace Wikia\ApiDocs\Services;

/**
 * Class IApiDocsService
 * @package Wikia\ApiDocs\Services
 * Implementing objects are providers of information about wiki apis.
 * To create @see Wikia\ApiDocs\Services\ApiDocsServiceFactory
 *
 * implementations:
 * @see Wikia\ApiDocs\Services\ApiDocsService
 * @see Wikia\ApiDocs\Services\CachingApiDocsService
 */
interface IApiDocsService {

	/**
	 * Returns list of available APIs.
	 * Example:
	 * array (size=3)
	 *   'apiVersion' => string '0.2' (length=3)
	 *   'swaggerVersion' => string '1.1' (length=3)
	 *   'apis' =>
	 *     array (size=11)
	 *       0 =>
	 *         array (size=3)
	 *           'readableName' => string 'ActivityApi' (length=11)
	 *           'path' => string '/wikia.php?controller=ApiDocs&method=api&api=ActivityApi' (length=56)
	 *           'description' => string 'Get information about the latest user activity on the current wiki' (length=66)
	 *       1 =>
	 *         array (size=3)
	 *           'readableName' => string 'ArticlesApi' (length=11)
	 *           'path' => string '/wikia.php?controller=ApiDocs&method=api&api=ArticlesApi' (length=56)
	 *           'description' => string 'Get the most viewed articles on this wiki' (length=41)
	 *       2 =>
	 *         array (size=3)
	 *           'readableName' => string 'NavigationApi' (length=13)
	 *           'path' => string '/wikia.php?controller=ApiDocs&method=api&api=NavigationApi' (length=58)
	 *           'description' => string 'Get wiki navigation links' (length=25)
	 * @return array
	 */
	function getDocList();

	/**
	 * Returns api docs for given API name.
	 * Example:
	 * array (size=6)
	 *   'basePath' => string 'http://www.wikia.com' (length=20)
	 *   'swaggerVersion' => string '1.1' (length=3)
	 *   'apiVersion' => string '0.2' (length=3)
	 *   'resourcePath' => string 'ArticlesApi' (length=11)
	 *   'apis' =>
	 *     array (size=6)
	 *       0 =>
	 *         array (size=3)
	 *           'path' => string '/wikia.php?controller=ArticlesApi&method=getDetails' (length=51)
	 *           'operations' =>
	 *             array (size=1)
	 *               ...
	 *           'description' => string 'Get top articles for the current wiki' (length=37)
	 *       1 =>
	 *       array (size=3)
	 *         'path' => string '/wikia.php?controller=ArticlesApi&method=getList' (length=48)
	 *         'operations' =>
	 *           array (size=1)
	 *             ...
	 *         'description' => string 'Get the most viewed articles for the current wiki' (length=49)
	 * @param string $name
	 * @return array
	 */
	function getDoc( $name );
}
