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
	protected $advObjectList = null;

	public function __construct() {

		$this->mainObjectList = array(
			"callofduty:Character" => 'structureddata-class-characters',
			"callofduty:Faction" => 'structureddata-class-factions',
			"callofduty:Weapon" => 'structureddata-class-weapons',
			"callofduty:Mission" => 'structureddata-class-missions',
			"callofduty:WeaponClass" => 'structureddata-class-weapon-classes',
			"wikia:Objective" => 'structureddata-class-objectives'
		);

		$this->advObjectList = array(
			'callofduty:Timeline' => 'structureddata-class-timelines',
			'wikia:VideoGame' => 'structureddata-class-video-games',
			'schema:ImageObject' => 'structureddata-class-image-objects',
			'schema:AudioObject' => 'structureddata-class-audio-objects',
			'wikia:GameLocation' => 'structureddata-class-game-location',
			'wikia:WikiText' => 'structureddata-class-wikitext-objects'
		);

		// parent SpecialPage constructor call MUST be done
		parent::__construct( 'StructuredData', '', false );

	}

	public function init() {
		global $wgStructuredDataConfig;
		$this->config = $this->wg->StructuredDataConfig;
		$this->APIClient = (new StructuredDataAPIClient(
			$wgStructuredDataConfig['baseUrl'],
			$wgStructuredDataConfig['apiPath'],
			$wgStructuredDataConfig['schemaPath']
		));
		$this->structuredData = new StructuredData( $this->APIClient );
	}

	public function index() {
		$par = $this->getPar();

		if(empty($par)) {
			$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
			$this->setVal( "mainObjects", $this->mainObjectList );
			$this->setVal( 'advObjects', $this->advObjectList );
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
		$success = $this->request->getVal( 'success', false );

		$isEditAllowed = $this->wg->User->isAllowed( 'sdsediting' );
		$isDeleteAllowed = $this->wg->User->isAllowed( 'sdsdeleting' );

		if ( ( ( $action == 'edit' || $action == 'create' ) && !$isEditAllowed ) || ( ( $action == 'delete' ) && !$isDeleteAllowed ) ) {
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

		if(empty($sdsObject) && ($action == 'create')) {
			$sdsObject = $this->structuredData->createSDElementByType( $type );
		}

		if(empty($sdsObject)) {
			$this->app->wg->Out->setStatusCode ( 400 );
		}
		else {
			if ( $action == 'delete' ) {
				$result = $this->structuredData->deleteSDElement( $sdsObject );
				if( isset( $result->error ) ) {
					$updateResult = $result;
					$action = 'render';
					$this->setVal('updateResult', $updateResult);
				} else {
					// if we removed the object, just redirect to the special page
					$this->skipRendering();
					$this->wg->out->redirect( SpecialPage::getTitleFor( 'StructuredData' )->getFullUrl() );
					return;
				}
			} else if($this->getRequest()->wasPosted()) {

				$requestParams = $this->getRequest()->getParams();
				$handlerResult = $this->alterRequestPerObject( $requestParams, $requestParams['type'] );

				if ( $handlerResult instanceof stdClass ) {
					$updateResult = $handlerResult;
				}
				else {
					$requestParams = $handlerResult;
					$result = $this->structuredData->updateSDElement($sdsObject, $requestParams);
					if( isset( $result->error ) ) {
						$updateResult = $result;
					}
					else {
						$this->wg->out->redirect( $sdsObject->getObjectPageUrl( SD_CONTEXT_SPECIAL ) . '?success=true' );
					}
				}

				$this->setVal('updateResult', $updateResult);
			}

			if( !empty( $success ) ) {
				$updateResult = new stdClass();
				$updateResult->message = wfMsg( 'structureddata-object-updated' );

				$this->setVal('updateResult', $updateResult);
			}
		}

		// Dropdown menu button values

		$dropDownItems = array(
			array(
				'href' => '?action=delete',
				'text' => wfMsg('structureddata-dropdown-button-delete'),
				'class' => 'SDObject-delete',
				'title' => 'Delete SDS Object'
			)
		);
		$menuButtonAction = array('text' => wfMsg('structureddata-dropdown-button-edit'), 'href' => '?action=edit');
		$this->setVal('dropDownItems', $dropDownItems);
		$this->setVal('menuButtonName', 'editSDObject');
		$this->setVal('menuButtonAction', $menuButtonAction);
		$this->setVal('menuButtonImage', MenuButtonController::EDIT_ICON);

		$this->response->addAsset('extensions/wikia/StructuredData/css/StructuredData.scss');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.core.css');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.theme.css');
		$this->response->addAsset('resources/jquery.ui/themes/default/jquery.ui.datepicker.css');
		$this->response->addAsset('resources/wikia/libraries/jquery-ui/themes/default/jquery.ui.timepicker.css');
		$this->response->addAsset('resources/wikia/libraries/mustache/mustache.js');
		$this->response->addAsset('resources/wikia/libraries/jquery-ui/jquery-ui-1.8.14.custom.js');
		$this->response->addAsset('resources/jquery.ui/jquery.ui.datepicker.js');
		$this->response->addAsset('resources/wikia/libraries/jquery-ui/jquery.ui.timepicker.js');
		$this->response->addAsset('extensions/wikia/StructuredData/js/StructuredData.js');
		$this->setVal('sdsObject', $sdsObject);
		$this->setVal('context', ( $action == 'edit' || $action == 'create' ) ? SD_CONTEXT_EDITING : SD_CONTEXT_SPECIAL );
		$this->setVal('isEditAllowed', $isEditAllowed);
		$this->setVal('isCreateMode', ( $action == 'create' ));
	}

	protected function alterRequestPerObject( $requestParams, $objectType) {

		if ( isset( $this->config['typeHandlers'][$objectType] ) ) {

			$handlerName = $this->config['typeHandlers'][$objectType];
		} else {
			$handlerName = 'SDTypeHandlerAnyType';
		}

		/* @var $handler SDTypeHandler */
		$handler = new $handlerName( $this->config );
		$params = $handler->handleSaveData( $requestParams );
		$result = $handler->getErrors();

		if ( !empty( $result->error ) ) {
			return $result;
		} else {
			return $params;
		}

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

				// TODO: remove 'schema:Photograph' from containers range
				if ($type === 'schema:Photograph' && in_array('schema:ImageObject', $objectTypes)) {
					continue;
				}

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

						// avoiding object duplication in collection
						$resultCollection[$item['id']] = $item;

					}
				}
			}

			$this->response->setVal( "list", array_values($resultCollection) );
			$this->setVal( "specialPageUrl", SpecialPage::getTitleFor( 'StructuredData' )->getFullUrl() );
			$this->setVal( "objectType", $objectType);
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

	public function createReferencedObject() {
		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setCacheValidity( 0, 0, array( WikiaResponse::CACHE_TARGET_BROWSER ) );
		if ( !$this->wg->User->isAllowed( 'sdsediting' ) ) {
			$this->response->setVal( 'error', wfMsg( 'structureddata-no-rights-to-add-wikitext-object' ) );
			return;
		}

		$objectName = $this->request->getVal('schema:name', false);
		$parentObjectId = $this->request->getVal('objectId');
		$parentPropertyName = $this->request->getVal('objectPropName');
		$type = $this->request->getVal('type', false);

		if( !empty( $objectName ) && !empty( $parentObjectId ) && !empty( $parentPropertyName ) ) {
			$alteredParams = $this->alterRequestPerObject( $this->getRequest()->getParams(), $type);
			$SDElement = $this->structuredData->createSDElement( $type, $alteredParams );

			if( $SDElement instanceof SDElement ) {
				$this->response->setVal( 'success', wfMsg( 'structureddata-created-wikitext-object' ) );

				$parentSDElement = $this->structuredData->getSDElementById( $parentObjectId );
				$parentProperty = $parentSDElement->getProperty( $parentPropertyName );
				if( $parentProperty instanceof SDElementProperty ) {
					$newReference = new stdClass;
					$newReference->id = $SDElement->getId();

					$parentProperty->appendValue( $newReference );
					$result = $this->structuredData->updateSDElement($parentSDElement);
					if( isset( $result->error ) ) {
						$this->response->setVal( 'error', $result->error );
					}
					else {
						$this->response->setVal( 'updateResult', wfMsg( 'structureddata-object-updated' ) );
					}
				}
				else {
					$this->response->setVal( 'error', wfMsg( 'structureddata-saving-reference-failed' ) );
				}
			}
			else {
				$this->response->setVal( 'error', $SDElement->error );
			}
		}
		else {
			$this->response->setVal( 'error', wfMsg( 'structureddata-invalid-arguments' ) );
		}
	}

}
