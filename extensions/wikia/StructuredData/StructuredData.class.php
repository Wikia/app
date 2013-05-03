<?php
/**
 * @author ADi
 */
class StructuredData {
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;
	/**
	 * @var SDContext
	 */
	private $context = null;

	public function __construct( StructuredDataAPIClient $apiClient = null) {
		global $wgStructuredDataConfig;
		if( is_null($apiClient ) ) {
			$apiClient = (new StructuredDataAPIClient(
				$wgStructuredDataConfig['baseUrl'],
				$wgStructuredDataConfig['apiPath'],
				$wgStructuredDataConfig['schemaPath']
			));
		}
		$this->context = new SDContext( $apiClient );
		$this->APIClient = $apiClient;
	}

	/**
	 * @param string $id
	 * @return SDElement
	 */
	public function getSDElementById($id) {
		try {
			$element = $this->APIClient->getObject( $id );
		}
		catch( WikiaException $exception ) {
			return null;
		}
		return $this->getSDElement( $element );
	}

	public function getSDElementByURL($url) {
		$element = $this->APIClient->getObjectByURL($url);
		return $this->getSDElement( $element );
	}

	public function getSDElementByTypeAndName($type, $name) {
		try {
			$element = $this->APIClient->getObjectByTypeAndName($type, $name);
		}
		catch( WikiaException $exception ) {
			return null;
		}
		return $this->getSDElement( $element );
	}

	/**
	 * fetch all objects of given type from SDS
	 * @param $type
	 * @return array
	 */
	public function getCollectionByType( $type, $extraFields = array() ) {
		return $this->APIClient->getCollection( $type, $extraFields );
	}

	public function createSDElementByType( $elementType, stdClass $template = null ) {
		if( empty( $template ) ) {
			$template = $this->APIClient->getTemplate( $elementType );
		}

		return SDElement::newFromTemplate( $template, $this->context, null, 0 );
	}

	public function createSDElement( $elementType, array $params = array() ) {
		$template = $this->APIClient->getTemplate( $elementType );
		$result = $this->updateSDElement( $this->createSDElementByType( $elementType, $template ), $params );

		if( isset( $result->error ) ) {
			return $result;
		}
		else {
			return SDElement::newFromTemplate( $template, $this->context, $result );
		}
	}

	public function updateSDElement(SDElement $element, array $params = array()) {
		if( count($params) ) {
			$element->update($params);
		}
//echo $element->toSDSJson();
//exit;
		$elementId = $element->getId();

		if( empty($elementId) ) {
			return $this->APIClient->createObject($element->toSDSJson());
		}
		else {
			return $this->APIClient->saveObject($element->getId(), $element->toSDSJson());
		}
	}

	/**
	 * Remove a single sds object
	 * @param SDElement $element - sds object to be removed
	 * @return mixed - JSON response from sds
	 */
	public function deleteSDElement(SDElement $element) {
		return $this->APIClient->deleteObject( $element->getId() );
	}

	private function getSDElement(stdClass $element) {
		$template = $this->APIClient->getTemplate( $element->type );

		$SDElement = SDElement::newFromTemplate( $template, $this->context, $element );

		return $SDElement;
	}

}
