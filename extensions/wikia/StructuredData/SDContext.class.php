<?php
/**
 * @author ADi
 */
class SDContext extends WikiaObject {
	const RESOURCE_CACHE_TTL = 60;
	const DESCRIPTION_CACHE_TTL = 60;

	protected $resources = array();
	protected $objectDescriptions = array();
	protected $types = array();
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;


	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->APIClient = $apiClient;
		parent::__construct();
	}

	public function addResource($resourceUrl, $relative = true, $elementType = null) {
		$resourceCacheKey = $this->wf->SharedMemcKey( 'SDContextResource', $resourceUrl );
		$resourceData = $this->wg->Memc->get( $resourceCacheKey );
		if(empty($resourceData)) {
			$resourceData = $this->APIClient->getContext( $resourceUrl, $relative );
			$this->resources[$resourceUrl] = $resourceData->{"@context"};

			$this->wg->Memc->set( $resourceCacheKey, $this->resources[$resourceUrl], self::RESOURCE_CACHE_TTL );
		}
		else {
			$this->resources[$resourceUrl] = $resourceData;
		}

		// @todo tmp hack! remove when API will be fixed back
		$elementType = null;
		if(!empty($elementType)) {
			$descriptionCacheKey = $this->wf->SharedMemcKey( 'SDContextDescription', $resourceUrl );
			$objectDescriptionData = $this->wg->Memc->get( $descriptionCacheKey );
			if(empty($objectDescriptionData)) {
				$objectDescriptionData = $this->APIClient->getObjectDescription( $elementType );
				$this->objectDescriptions[$elementType] = $objectDescriptionData;

				$this->wg->Memc->set( $descriptionCacheKey, $this->objectDescriptions[$elementType], self::DESCRIPTION_CACHE_TTL );
			}
			else {
				$this->objectDescriptions[$elementType] = $objectDescriptionData;
			}
		}

		$this->processResource($resourceUrl, $elementType);
	}

	public function getType($name) {
		return isset($this->types[$name]) ? $this->types[$name] : false;
	}

	private function processResource($resourceUrl, $elementType = null) {
		foreach($this->resources[$resourceUrl] as $typeName => $data) {
			if($data instanceof stdClass) {
				if(isset($data->{"@type"})) {
					$this->types[$typeName] = array( "name" => $data->{"@type"}, "range" => null );
				}
				else if(isset($data->{"@container"})) {
					$type = array( "name" => $data->{"@container"}, "range" => null );

					if(!empty($elementType)) {
						$propertyDescription = $this->getPropertyDescription( $elementType, $typeName );
						if(!empty($propertyDescription)) {
							$type['range'] = $propertyDescription->range;
						}
					}
					$this->types[$typeName] = $type;
				}
			}
		}
	}

	private function getPropertyDescription( $objectType, $propertyName ) {
		// @todo re-check after term definition will be fixed (?)
		foreach($this->objectDescriptions[$objectType]->{"properties"} as $propertyDescription) {
			if($propertyDescription->id == $propertyName) {
				return $propertyDescription;
			}
		}
		return null;
	}
}
