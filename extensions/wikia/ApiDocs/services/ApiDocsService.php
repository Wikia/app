<?php

namespace Wikia\ApiDocs\Services;

class ApiDocsService {
	/**
	 * @var \Swagger\Swagger
	 */
	private $swagger;

	/**
	 * @var callable
	 */
	private $pathBuilder;

	/**
	 * @param  /Swagger/Swagger $swagger
	 * @param callable $pathBuilder
	 * @internal param $ /Swagger/Swagger $swagger
	 */
	function __construct( $swagger, $pathBuilder ) {
		$this->swagger = $swagger;
		$this->pathBuilder = $pathBuilder;

		$errors = [];

		\Swagger\Logger::getInstance()->log = function ($entry, $type) use (&$errors) {
			$type = $type === E_USER_NOTICE ? 'INFO' : 'WARN';
			if ($entry instanceof \Exception) {
				$entry = $entry->getMessage();
			}
			$errors[] = '[' . $type . '] ' . $entry . "\n";
		};
	}

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
			$cb = ($this->pathBuilder);
			$path = $cb( $resource->resourcePath );

			$result['apis'][] = array(
				'path' => $path,
				'description' => $resource->apis[0]->description
			);
		}
		return $result;
	}

	function getDoc( $name ) {
		return \WikiaDataAccess::cache( wfMemcKey( 'ApiDocsService', $name ), 60, function() use($name) {
			return $this->swagger->getResource( $name, false, false );
		} );
	}
}
