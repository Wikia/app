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
	 * @param int $id
	 * @param int $elementDepth
	 * @return SDElement
	 */
	public function getSDElementById($id, $elementDepth = 0) {
		$element = $this->APIClient->getObject($id);
		return $this->getSDElement( $element, $elementDepth );
	}

	public function getSDElementByURL($url, $elementDepth = 0) {
		$element = $this->APIClient->getObjectByURL($url);
		return $this->getSDElement( $element, $elementDepth );
	}

	private function getSDElement(stdClass $element, $elementDepth = 0) {
		$template = $this->APIClient->getTemplate( $element->type );

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $element, 'depth' => $elementDepth ), 'newFromTemplate');

		return $SDElement;
	}

}
