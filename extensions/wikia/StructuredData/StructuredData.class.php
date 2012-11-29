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

	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->context = F::build( 'SDContext', array( 'apiClient' => $apiClient ) );
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

		return F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => null, 'depth' => 0 ), 'newFromTemplate' );
	}

	public function createSDElement( $elementType, array $params = array() ) {
		$template = $this->APIClient->getTemplate( $elementType );
		$result = $this->updateSDElement( $this->createSDElementByType( $elementType, $template ), $params );

		if( isset( $result->error ) ) {
			return $result;
		}
		else {
			return F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $result ), 'newFromTemplate' );
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

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $element ), 'newFromTemplate');

		return $SDElement;
	}

}
