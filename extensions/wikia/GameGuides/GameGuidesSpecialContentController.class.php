<?php

class GameGuidesSpecialContentController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct( 'GameGuidesContent', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidescontent' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$title = $this->wf->Msg( 'wikiagameguides-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules( 'jquery.autocomplete' );

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getUrl( 'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss' );

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL( 'extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js' );

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$categories = WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId );

		$this->response->setVal( 'categories', $categories );
	}

	public function save(){
		if (!$this->wg->User->isAllowed( 'gameguidescontent' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$categories = $this->getVal( 'categories' );
		$err = array();

		foreach ( $categories as $categoryName => $values) {
			$categoryTitle = Title::newFromText( $categoryName, NS_CATEGORY );

			if ( $categoryTitle instanceof Title && $categoryTitle->exists() ) {
			} else {
				$err[] = $categoryName;
			}
		}

		if ( !empty( $err ) ) {
			$this->response->setVal( 'error', $err );
			return true;
		}

		$status = WikiFactory::setVarByName( 'wgWikiaGameGuidesContent', $this->wg->CityId, $categories );
		$this->response->setVal( 'status', $status );
		return true;
	}
}
