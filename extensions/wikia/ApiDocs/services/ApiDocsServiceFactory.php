<?php
namespace Wikia\ApiDocs\Services;

use Swagger\Swagger;

/**
 * Class ApiDocsServiceFactory
 * @package Wikia\ApiDocs\Services
 * Creates Wikia\ApiDocs\Services\IApiDocsService instance
 */
class ApiDocsServiceFactory {
	/**
	 * Will create cached ApiDocsService.
	 * @see Wikia\ApiDocs\Services\ApiDocsService
	 * @see Wikia\ApiDocs\Services\CachingApiDocsService
	 * @return IApiDocsService
	 */
	public function getApiDocsService() {
		global $IP;
		$swagger = Swagger::discover( $IP . "/includes/wikia/api/" );
		$docsService = new ApiDocsService(
			$swagger,
			function( $x ) { return "/wikia.php?controller=ApiDocs&method=api&api=" . $x; }
		);
		return new CachingApiDocsService( $docsService, \F::app()->wg->CacheBuster );
	}
}
