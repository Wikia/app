<?php
if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

class SkinOasis extends WikiaSkin {
	public function __construct( string $skinName ) {
		parent::__construct( $skinName );

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

	protected function getTemplate(): QuickTemplate {
		return new OasisTemplate();
	}
}

class OasisTemplate extends WikiaSkinTemplate {
	function execute() {
		$this->app->setSkinTemplateObj($this);
		$response = $this->app->sendRequest( Wikia::getVar( 'OasisEntryControllerName', 'Oasis' ), 'index', null, false );
		$response->sendHeaders();
		$response->render();
	}
}
