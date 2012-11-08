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

		$styles = $assetManager->getURL(
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss'
		);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL(
			'extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js'
		);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$tags = WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId );

		$this->response->setVal( 'tags', $tags );
		return true;
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'gameguidescontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$categories = $this->getVal( 'categories' );
		$err = array();
		$tags = array();

		if( !empty( $categories ) ) {
			//check if categories exists
			foreach ( $categories as $categoryName => $values) {
				$category = Category::newFromName( $categoryName );

				if ( !( $category instanceof Category ) || $category->getPageCount() === 0 ) {
					$err[] = $categoryName;
				} else if ( empty( $err ) ) {

					$category = array(
						'name' => $categoryName
					);

					if ( !empty( $values['name'] ) ) {
						$category['label'] = $values['name'];
					}

					if ( array_key_exists( $values['tag'], $tags ) ) {
						$tags[$values['tag']]['categories'][] = $category;
					} else {
						$tags[$values['tag']] = array(
							'name' => $values['tag'],
							'categories' => array(
								$category
							)
						);
					}
				}
			}

			if ( !empty( $err ) ) {
				$this->response->setVal( 'error', $err );
				return true;
			}
		}

		$status = WikiFactory::setVarByName( 'wgWikiaGameGuidesContent', $this->wg->CityId, array_values( $tags ) );
		$this->response->setVal( 'status', $status );

		if ( $status ) {
			$this->wf->RunHooks( 'GameGuidesContentSave' );
		}

		return true;
	}

	//This should appear on WikiFeatures list only when GG extension is turned on and be visible only to staff
	static public function onWikiFeatures(){
		$wg = F::app()->wg;

		if ( $wg->User->isAllowed( 'gameguidescontent-switchforadmins' ) ) {
			$wg->append(
				'wgWikiFeatures',
				'wgGameGuidesContentForAdmins',
				'normal'
			);
		}

		return true;
	}
}
