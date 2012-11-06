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

		$isStaff = in_array( 'staff', $this->wg->User->getEffectiveGroups() );

		$title = $this->wf->Msg( 'wikiagameguides-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules( 'jquery.autocomplete' );

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL(
			array_merge(
				array(
					'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss',
				),
				($isStaff ? array(
					'extensions/wikia/WikiFeatures/css/WikiFeatures.scss'
				) : array())
			)
		);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL(
			array_merge(
				array(
					'extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js'
				),
				($isStaff ? array(
					'extensions/wikia/WikiFeatures/js/modernizr.transform.js',
					'extensions/wikia/WikiFeatures/js/WikiFeatures.js'
				) : array())
			)
		);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$tags = WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId );

		if ( $isStaff ) {
			$this->response->setVal( 'enabled', $enabled = WikiFactory::getVarValueByName( 'wgGameGuidesContentForAdmins', $this->wg->CityId ) );
		}

		$this->response->setVal( 'staff', $isStaff );
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

					if ( array_key_exists( $values['tag'], $tags ) ) {
						$tags[$values['tag']]['categories'][] = array(
							'category' => $categoryName,
							'name' => $values['name']
						);
					} else {
						$tags[$values['tag']] = array(
							'name' => $values['tag'],
							'categories' => array(
								array(
									'category' => $categoryName,
									'name' => $values['name']
								)
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
}
