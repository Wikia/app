<?php

/**
 * Special:MiniEditor
 * 
 * @author Liz Lee, Kyle Florence
 */

class MiniEditorSpecialController extends WikiaSpecialPageController {

	public function __construct() {

		// Params: name, restrictions, listed
		parent::__construct( 'MiniEditor', '', false );
	}

	public function index() {
		$this->sendRequest('MiniEditor', 'loadAssets', array(
			'additionalAssets' => array(
				'extensions/wikia/MiniEditor/js/SpecialPage.js',
				'extensions/wikia/MiniEditor/css/SpecialPage.scss'
			)
		));
	}
}
