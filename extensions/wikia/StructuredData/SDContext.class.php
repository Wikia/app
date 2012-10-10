<?php
/**
 * @author ADi
 */
class SDContext {

	protected $resources = array();
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;


	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->APIClient = $apiClient;
	}

	public function addResource($resourceUrl, $relative) {

		$resourceData = $this->APIClient->getContext( $resourceUrl, $relative );
		var_dump($resourceData);

		$this->resources[$resourceUrl] = $resourceData;
	}
}
