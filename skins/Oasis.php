<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinOasis extends WikiaSkin {
	function __construct() {
		parent::__construct( 'OasisTemplate', 'oasis' );

		//non-strict checks of css/js/scss assets/packages
		$this->strictAssetUrlCheck = false;
	}

	function setupSkinUserCss( OutputPage $out ) {}

	/**
	 * Oasis handles OutputPage::mScripts differently
	 * so we don't want them to be duplicated
	 *
	 * @return string
	 */
	public function bottomScripts() {
		$bottomScripts = parent::bottomScripts();
		$bottomScripts = str_replace( $this->wg->out->getScriptsOnly(), '', $bottomScripts );
		return $bottomScripts;
	}
}

class OasisTemplate extends WikiaSkinTemplate {
	function execute() {
		$this->app->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( Wikia::getVar( 'OasisEntryControllerName', 'Oasis' ), 'Index', null, false );
		$response->sendHeaders();
		$response->render();
	}
}
