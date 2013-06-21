<?php

/**
 * Special:MiniEditorDemo
 * 
 * @author Liz Lee, Kyle Florence
 */

class MiniEditorSpecialController extends WikiaSpecialPageController {

	public function __construct() {

		// Params: name, restrictions, listed
		parent::__construct( 'MiniEditorDemo', '', false );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMsg( 'minieditor-specialpage-title' ) );

		if ( !$this->wg->User->isAllowed( 'minieditor-specialpage' ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->sendRequest('MiniEditor', 'loadAssets', array(
			'additionalAssets' => array(
				'extensions/wikia/MiniEditor/js/SpecialPage.js',
				'extensions/wikia/MiniEditor/css/SpecialPage.scss'
			)
		));
	}
}
