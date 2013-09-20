<?php

namespace Wikia\ApiDocs\Services;

/**
 * Class ApiDocsService
 * @package Wikia\ApiDocs\Services
 * Don't create directly @see Wikia\ApiDocs\Services\ApiDocsServiceFactory
 */
class ApiDocsService implements IApiDocsService {
	/**
	 * @var \Swagger\Swagger
	 * Original swagger object
	 */
	private $swagger;

	/**
	 * @var callable used by getDocList to generate api paths
	 * i.e. function( $x ) { return "/wikia.php?controller=ApiDocs&method=api&api=" . $x; }
	 */
	private $pathBuilder;


	/**
	 * @param /Swagger/Swagger $swagger
	 * @param callable $pathBuilder
	 */
	function __construct( $swagger, $pathBuilder ) {
		$this->swagger = $swagger;
		$this->pathBuilder = $pathBuilder;
	}

	/**
	 * Returns list of available APIs.
	 * @return array
	 */
	function getDocList() {

		$result = [];
		foreach ( $this->swagger->getRegistry() as $resource) {
			if (!$result) {
				$result = [
					'apiVersion' => $this->swagger->getDefaultApiVersion() ?: $resource->apiVersion,
					'swaggerVersion' => $this->swagger->getDefaultSwaggerVersion() ?: $resource->swaggerVersion,
					'apis' => []
				];
			}
			/** @var \Swagger\Annotations\Resource $resource  */
			$cb = $this->pathBuilder;
			$path = $cb( $resource->resourcePath );

			$result['apis'][] = array(
				'readableName' => $resource->resourcePath,
				'path' => $path,
				'description' => $resource->apis[0]->description
			);
		}
		return $result;
	}

	/**
	 * Returns api docs for given API name.
	 * @param string $name
	 * @return array
	 */
	function getDoc( $name ) {
		return $this->swagger->getResource( $name, false, false );
	}
}

/*
$errors = [];

\Swagger\Logger::getInstance()->log = function ($entry, $type) use (&$errors) {
	$type = $type === E_USER_NOTICE ? 'INFO' : 'WARN';
	if ($entry instanceof \Exception) {
		$entry = $entry->getMessage();
	}
	$errors[] = '[' . $type . '] ' . $entry . "\n";
};
*/
