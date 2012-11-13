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

		if( $action == 'edit' && !$this->wg->User->isAllowed( 'sdsediting' ) ) {
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
				$sdsObject->update($this->getRequest()->getParams());
				$this->APIClient->saveObject($sdsObject->getId(), $sdsObject->toSDSJson());
				$action = 'render';
			}
		}

		$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
		$this->response->addAsset('resources/wikia/libraries/mustache/mustache.js');
		$this->response->addAsset('extensions/wikia/StructuredData/js/StructuredData.js');
		$this->setVal('sdsObject', $sdsObject);
		$this->setVal('context', ( $action == 'edit' ) ? SD_CONTEXT_EDITING : SD_CONTEXT_SPECIAL );
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
		$objectType = $this->request->getVal( 'objectType', false );
		if( !empty( $objectType ) ) {
			$collection = $this->structuredData->getCollectionByType( $objectType );
			$this->response->setVal( "list", $collection );
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
