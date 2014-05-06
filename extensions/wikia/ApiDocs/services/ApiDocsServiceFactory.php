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
	public function getApiDocsService($request) {
		global $IP;
		$matches = [];
		if ( preg_match( "/(\/api\/[^\/]+)\//", $request->getScriptUrl(), $matches ) ) {
			$pathPrefix = $matches[1];
			$docsService = new ApiDocsService(
				Swagger::discover( $IP . "/includes/wikia/api/swagger" ),
				function( $x ) { return "Docs/Api?name=" . $x; } ,
				$pathPrefix
			);
			return new CachingApiDocsService( $docsService, \F::app()->wg->CacheBuster . $pathPrefix );	
		} else {
			throw new \NotFoundApiException( 'Unrecognized entrypoint ' . $request->getScriptUrl() );
		}
	}
}
