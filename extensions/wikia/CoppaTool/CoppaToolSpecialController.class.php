<?php
/**
 * COPPA Tool special page
 * @author grunny
 */

class CoppaToolSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'CoppaTool', 'coppatool' );
	}

	public function index() {
		global $wgCentralWikiId;
		$title = GlobalTitle::newFromText( 'CoppaTool', NS_SPECIAL, $wgCentralWikiId );
		$this->getOutput()->redirect( $title->getFullURL() );
	}
}
