<?php
/**
 * @author ADi
 */

class StructuredDataController extends WikiaSpecialPageController {

	protected $config = null;
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;
	/**
	 * @var StructuredData
	 */
	protected $structuredData = null;

	public function __construct() {
		// parent SpecialPage constructor call MUST be done
		parent::__construct( 'StructuredData', '', false );

	}

	public function init() {
		$this->config = $this->wg->StructuredDataConfig;
		$this->APIClient = F::build( 'StructuredDataAPIClient', array( 'endpoint' => $this->config['endpointUrl'], 'schemaUrl' => $this->config['schemaUrl'] ) );
		$this->structuredData = F::build( 'StructuredData', array( 'apiClient' => $this->APIClient ));
	}

	public function index() {
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/StructuredData/js/StructuredData.js" ) ) );

		//$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
	}

	public function getObject() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$id = $this->request->getVal( 'id', false );

		if(!empty($id)) {
			$object = $this->structuredData->getSDElement( $id );

			$this->response->setBody( (string) $object );
		}
	}

	public function getCollection() {

	}

	public function getTemplate() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$objectType = $this->request->getVal( 'objectType', false );

		if(!empty($objectType)) {
			$template = $this->APIClient->getTemplate( $objectType );

			$this->response->setBody( $template );
		}
	}

}
