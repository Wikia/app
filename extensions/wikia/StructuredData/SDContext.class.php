<?php
/**
 * @author ADi
 */
class SDContext extends WikiaObject {
	const RESOURCE_CACHE_TTL = 300;
	const DESCRIPTION_CACHE_TTL = 300;

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
		$resourceCacheKey = wfSharedMemcKey( 'SDContextResource', $resourceUrl );
		$resourceData = $this->wg->Memc->get( $resourceCacheKey );
		if(empty($resourceData)) {
			$resourceData = $this->APIClient->getContext( $resourceUrl, $relative );
			if(!empty($resourceData)) {
				$this->resources[$resourceUrl] = $resourceData->{"@context"};
				$this->wg->Memc->set( $resourceCacheKey, $this->resources[$resourceUrl], self::RESOURCE_CACHE_TTL );
			}
			else {
				// @todo fetching context failed, possible error that need to be fixed on SDS side or escalated here.
				return false;
			}
		}
		else {
			$this->resources[$resourceUrl] = $resourceData;
		}

		if(!empty($elementType)) {
			$descriptionCacheKey = wfSharedMemcKey( 'SDContextDescription', $elementType );
			$objectDescriptionData = $this->wg->Memc->get( $descriptionCacheKey );
			if(empty($objectDescriptionData)) {
				$objectDescriptionData = $this->APIClient->getObjectDescription( $elementType );
				if(!empty($objectDescriptionData)) {
					$this->objectDescriptions[$elementType] = $objectDescriptionData;
					$this->wg->Memc->set( $descriptionCacheKey, $this->objectDescriptions[$elementType], self::DESCRIPTION_CACHE_TTL );
				} else {
					// @todo - error handling
					return false;
				}
			} else {
				$this->objectDescriptions[$elementType] = $objectDescriptionData;
			}
		}

		$this->processResource($resourceUrl, $elementType);
		return true;
	}

	public function getType($name) {
		return isset($this->types[$name]) ? $this->types[$name] : false;
	}

	public function getTypes() {
		return $this->types;
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

	public function getPropertyDescription( $objectType, $propertyName ) {
		if ( isset( $this->objectDescriptions[$objectType]->{"properties"} ) ) {
			foreach($this->objectDescriptions[$objectType]->{"properties"} as $propertyDescription) {
				if($propertyDescription->id == $propertyName) {
					return $propertyDescription;
				}
			}
		}
		return null;
	}
}
