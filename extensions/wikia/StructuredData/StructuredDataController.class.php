<?php
/**
 * @author ADi
 * @author Jacek Jursza
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

	protected $mainObjectList = null;

	public function __construct() {

		$this->mainObjectList = array(
			"callofduty:Character" => "Characters",
			"callofduty:Faction" => "Factions",
			"callofduty:Timeline" => "Timelines",
			"callofduty:Weapon" => "Weapons",
			"callofduty:WeaponClass" => "Weapon Class",
			"callofduty:Mission" => "Missions"
		);

		// parent SpecialPage constructor call MUST be done
		parent::__construct( 'StructuredData', '', false );

	}

	public function init() {
		$this->config = $this->wg->StructuredDataConfig;
		$this->APIClient = F::build( 'StructuredDataAPIClient' );
		$this->structuredData = F::build( 'StructuredData', array( 'apiClient' => $this->APIClient ));
	}

	public function index() {
		$par = $this->getPar();

		if(empty($par)) {
			$this->response->addAsset('/extensions/wikia/StructuredData/js/StructuredData.js');
			$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
			$this->setVal( "mainObjects", $this->mainObjectList );
		}
		else {
			$pos = strpos($par, '/');
			if ( $pos !== false) {
				$type = substr($par, 0, $pos);
				$name = substr($par, $pos + 1);
				$type = str_replace('+', ' ', $type);
				$name = str_replace('+', ' ', $name);
				$this->request->setVal( 'type', $type );
				$this->request->setVal( 'name', $name );
			} else {
				$this->request->setVal( 'url', $par );
			}


			$this->forward( 'StructuredData', 'showObject' );
		}
	}

	/**
	 * Display HTML page with SDS object details. SDS object hash should be passes in
	 * 'id' request parameter
	 */
	public function showObject() {
		/** @var $sdsObject SDElement */
		$sdsObject = null;

		$id = $this->request->getVal( 'id', false );
		$url = $this->request->getVal( 'url', false );
		$type = $this->request->getVal( 'type', false );
		$name = $this->request->getVal( 'name', false );
		$action = $this->request->getVal( 'action', 'render' );

		$isEditAllowed = $this->wg->User->isAllowed( 'sdsediting' );
		if( ( $action == 'edit' ) && !$isEditAllowed ) {
			$this->displayRestrictionError($this->wg->User);
			$this->skipRendering();
			return false;
		}

		if ( !empty( $type ) && !empty( $name ) ) {
			try {
				$sdsObject = $this->structuredData->getSDElementByTypeAndName( $type, $name );
			} catch( WikiaException $e ) {
				$this->app->wg->Out->setStatusCode ( 404 );
			}
		}

		if(!empty($id)) {
			try {
				$sdsObject = $this->structuredData->getSDElementById( $id );
			} catch( WikiaException $e ) {
				$this->app->wg->Out->setStatusCode ( 404 );
			}
		}

		if(!empty($url)) {
			try {
				$sdsObject = $this->structuredData->getSDElementByURL( $url );
			} catch( WikiaException $e ) {
				$this->app->wg->Out->setStatusCode ( 404 );
			}
		}

		if(empty($sdsObject)) {
			$this->app->wg->Out->setStatusCode ( 400 );
		}
		else {
			if($this->getRequest()->wasPosted()) {
				$result = $this->structuredData->updateSDElement($sdsObject, $this->getRequest()->getParams());
				if( isset($result->error) ) {
					$updateResult = $result;
					$action = 'edit';
				}
				else {
					$updateResult = new stdClass();
					$updateResult->error = false;
					$updateResult->message = wfMsg( 'structureddata-object-updated' );
					$action = 'render';
				}
				$this->setVal('updateResult', $updateResult);
			}
		}

		$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.core.css');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.theme.css');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.datepicker.css');
		$this->response->addAsset('resources/wikia/libraries/jquery-ui/themes/default/jquery.ui.timepicker.css');
		$this->response->addAsset('resources/wikia/libraries/mustache/mustache.js');
		$this->response->addAsset('resources/wikia/libraries/jquery-ui/jquery-ui-1.8.14.custom.js');
		$this->response->addAsset('resources/jquery.ui/jquery.ui.datepicker.js');
		$this->response->addAsset('extensions/wikia/StructuredData/js/jquery-ui-timepicker.js');
		$this->response->addAsset('extensions/wikia/StructuredData/js/StructuredData.js');
		$this->setVal('sdsObject', $sdsObject);
		$this->setVal('context', ( $action == 'edit' ) ? SD_CONTEXT_EDITING : SD_CONTEXT_SPECIAL );
		$this->setVal('isEditAllowed', $isEditAllowed);
	}

	public function getObject() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$id = $this->request->getVal( 'id', false );
		$url = $this->request->getVal( 'url', false );

		$object = null;
		if(!empty($id)) {
			$object = $this->structuredData->getSDElementById( $id );
		}
		else if(!empty($url)) {
			$object = $this->structuredData->getSDElementByURL( $url );
		}

		if(is_object($object)) {
			$this->response->setBody( (string) $object );
		}
	}

	public function getObjectDescription() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$objectType = $this->request->getVal( 'objectType', false );
		if( !empty( $objectType ) ) {
			$description = $this->APIClient->getObjectDescription( $objectType, true );

			$this->response->setBody( $description );
		}
	}

	public function getCollection() {

		// configure additional fields per object type
		$specialFields = array(
			'schema:ImageObject' => array('schema:contentURL')
		);

		$objectType = $this->request->getVal( 'objectType', false );
		if( !empty( $objectType ) ) {

			$resultCollection = array();

			// types came from the request as coma-separated list
			$objectTypes = explode(",", $objectType);

			foreach ( $objectTypes as $type ) {

				$getSpecialFields = array();
				if ( isset( $specialFields[ $type ] ) ) $getSpecialFields = $specialFields[ $type ];
				$collection = $this->structuredData->getCollectionByType( $objectTypes[0], $getSpecialFields );

				if ( is_array( $collection ) ) {

					foreach ( $collection as $item ) {

						$specialPageUrl = null;
						if ( isset( $item['name'] ) && isset( $item['type'] ) ) {
							$specialPageUrl = SDElement::createSpecialPageUrl( $item );
						}
						$item['url'] = $specialPageUrl;

						if ( !in_array( $item, $resultCollection ) ) {
							$resultCollection[] = $item;
						}
					}
				}
			}
			$this->response->setVal( "list", $resultCollection );
		}
	}

	public function getTemplate() {
		// force json format
		$this->getResponse()->setFormat( 'json' );

		$objectType = $this->request->getVal( 'objectType', false );

		if(!empty($objectType)) {
			$template = $this->APIClient->getTemplate( $objectType, true );

			$this->response->setBody( $template );
		}
	}

}
