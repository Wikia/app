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
	public function getSDElement($id, $elementDepth = 0) {
		$element = $this->APIClient->getObject($id);
		$template = $this->APIClient->getTemplate( $element->type );

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $element, 'depth' => $elementDepth ), 'newFromTemplate');

		return $SDElement;
	}

}
