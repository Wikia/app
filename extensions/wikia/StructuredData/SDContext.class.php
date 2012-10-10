<?php
/**
 * @author ADi
 */
class SDContext extends WikiaObject {
	const RESOURCE_CACHE_TTL = 60;

	protected $resources = array();
	protected $types = array();
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;


	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->APIClient = $apiClient;
		parent::__construct();
	}

	public function addResource($resourceUrl, $relative = true) {
		$cacheKey = $this->wf->SharedMemcKey( 'SDContextResource', $resourceUrl );

		$resourceData = $this->wg->Memc->get( $cacheKey );
		if(empty($resourceData)) {
			$resourceData = $this->APIClient->getContext( $resourceUrl, $relative );

			$this->resources[$resourceUrl] = $resourceData->{"@context"};

			$this->wg->Memc->set( $cacheKey, $this->resources[$resourceUrl], self::RESOURCE_CACHE_TTL );
		}
		else {
			$this->resources[$resourceUrl] = $resourceData;
		}

		$this->processResource($resourceUrl);
	}

	public function getType($name) {
		return isset($this->types[$name]) ? $this->types[$name] : $name;
	}

	private function processResource($resourceUrl) {
		foreach($this->resources[$resourceUrl] as $typeName => $data) {
			if($data instanceof stdClass) {
				if(isset($data->{"@type"})) {
					$this->types[$typeName] = $data->{"@type"};
				}
			}
		}
	}
}
