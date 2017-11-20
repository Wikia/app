<?php
namespace Wikia\ApiDocs\Services;

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
		global $IP, $wgStyleVersion;
		$matches = [];
		if ( preg_match( "/(\/api\/[^\/]+)/", $request->getScriptUrl(), $matches ) ) {
			$pathPrefix = $matches[1];
			$swagger = new \Swagger($IP . self::SWAGGER_PATH . "/nirvana.json" );
			$docsService = new ApiDocsService(
				$swagger,
				function( $x ) { return self::API_DOC_PATH . $x; } ,
				$pathPrefix
			);
			return new CachingApiDocsService( $docsService, $wgStyleVersion . $pathPrefix );
		} else {
			throw new \NotFoundApiException( 'Unrecognized entrypoint ' . $request->getScriptUrl() );
		}
	}
}
