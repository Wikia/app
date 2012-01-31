<?php

/**
 * This is an example use of SpecialPage controller
 * 
 * @author ADi
 *
 */
class MiniEditorSpecialController extends WikiaSpecialPageController {

	private $businessLogic = null;
	private $controllerData = array();

	public function __construct() {
		$this->controllerData[] = 'foo';
		$this->controllerData[] = 'bar';
		$this->controllerData[] = 'baz';

		// standard SpecialPage constructor call
		parent::__construct( 'MiniEditor', '', false );
	}


	/**
	 * @brief this is default method, which in this example just redirects to Hello method
	 * @details No parameters
	 *
	 */
	public function index() {
		$this->response->setVal("test","test");

		// Load MiniEditor assets, if enabled
		if ($this->wg->EnableMiniEditorExt) {
			$this->sendRequest('MiniEditor', 'loadAssets', array(
				'additionalAssets' => array(
					'extensions/wikia/MiniEditor/js/SpecialPage.js',
					'extensions/wikia/MiniEditor/css/SpecialPage.scss'
				)
			));
		}

	}

	/**
	 * @brief Hello method
	 * @details Hello method
	 *
	 * @requestParam int $wikiId
	 * @responseParam string $header
	 * @responseParam array $wikiData
	 */
	/*public function MiniEditor() {
		$this->wf->profileIn( __METHOD__ );

		// getting request data
		$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );

		// setting response data
		$this->setVal( 'header', $this->wf->msg('helloworld-hello-msg') );
		$this->setVal( 'wikiData', $this->businessLogic->getWikiData( $wikiId ) );
		$this->setVal( 'controllerData', $this->controllerData );

		// example of setting SpecialPage::mIncluding
		$this->mIncluding = true;

		$this->wf->profileOut( __METHOD__ );
	}*/

}
