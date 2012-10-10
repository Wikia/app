<?php
/**
 * @author ADi
 */
class StructuredData {
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;
	private $contexts = array();

	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->APIClient = $apiClient;
	}

	public function getSDElement($id) {

		$elementJson = $this->APIClient->getObject($id);
		$element = json_decode( $elementJson );

		$templateJson = $this->APIClient->getTemplate( $element->type );
		$template = json_decode( $templateJson );

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'data' => $element ), 'newFromTemplate');

		return $SDElement;
	}

}
