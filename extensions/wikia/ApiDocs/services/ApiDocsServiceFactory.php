<?php
namespace Wikia\ApiDocs\Services;

use Swagger\Swagger;

/**
 * Class ApiDocsServiceFactory
 * @package Wikia\ApiDocs\Services
 * Creates Wikia\ApiDocs\Services\IApiDocsService instance
 */
class ApiDocsServiceFactory {
	
	const SWAGGER_PATH = "/includes/wikia/api/swagger";
	const API_DOC_PATH = "Docs/Api?name=";
	
	/**
	 * Will create cached ApiDocsService.
	 * @see Wikia\ApiDocs\Services\ApiDocsService
	 * @see Wikia\ApiDocs\Services\CachingApiDocsService
	 * @return IApiDocsService
	 */
	public function getApiDocsService( $request ) {
		global $IP;
		$matches = [];
		if ( preg_match( "/(\/api\/[^\/]+)/", $request->getScriptUrl(), $matches ) ) {
			$pathPrefix = $matches[1];
			$docsService = new ApiDocsService(
				Swagger::discover( $IP . self::SWAGGER_PATH ),
				function( $x ) { return self::API_DOC_PATH . $x; } ,
				$pathPrefix
			);
			return new CachingApiDocsService( $docsService, \F::app()->wg->CacheBuster . $pathPrefix );	
		} else {
			throw new \NotFoundApiException( 'Unrecognized entrypoint ' . $request->getScriptUrl() );
		}
	}
}
