<?php

namespace Wikia\ApiDocs\Services;

/**
 * Class CachingApiDocsService
 * @package Wikia\ApiDocs\Services
 * This is caching layer for @see Wikia\ApiDocs\Services\ApiDocsService
 * Don't create directly @see Wikia\ApiDocs\Services\ApiDocsServiceFactory
 */
class CachingApiDocsService implements IApiDocsService {
	/**
	 * @var IApiDocsService
	 */
	private $internalApiDocsService;

	/**
	 * @var int cache time. default value set to  12h. We are using cacheBuster so caching for 12h should not be a problem.
	 */
	private $cacheTime = 43200; // 60 * 60 * 12

	/**
	 * @var int|string cache buster for caching docs service. set it $wgStyleVersion for example.
	 */
	private $cacheBuster;

	/**
	 * @param IApiDocsService $internalApiDocsService internal api docs
	 * @param $cacheBuster
	 */
	function __construct( IApiDocsService $internalApiDocsService, $cacheBuster) {
		$this->internalApiDocsService = $internalApiDocsService;
		$this->cacheBuster = $cacheBuster;
	}

	/**
	 * @return array
	 */
	function getDocList() {
		return \WikiaDataAccess::cache( wfMemcKey( 'ApiDocsService', "getDocList", $this->cacheBuster ), $this->cacheTime, function() {
			return $this->internalApiDocsService->getDocList();
		} );
	}

	/**
	 * @param string $name
	 * @return array
	 */
	function getDoc( $name ) {
		return \WikiaDataAccess::cache( wfMemcKey( 'ApiDocsService', $name, $this->cacheBuster ), $this->cacheTime, function() use($name) {
			return $this->internalApiDocsService->getDoc( $name );
		} );
	}
}
