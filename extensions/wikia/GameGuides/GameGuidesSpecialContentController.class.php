<?php

class GameGuidesSpecialContentController extends WikiaSpecialPageController {

	const WIKI_FACTORY_VARIABLE_NAME = 'wgWikiaGameGuidesContent';
	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'GameGuidesContent', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidescontent' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = $this->wf->Msg( 'wikiagameguides-content-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules([
			'jquery.autocomplete',
			'jquery.ui.sortable'
		]);

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL(
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss'
		);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL([
			'/resources/wikia/libraries/mustache/mustache.js',
			'/extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js'
		]);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$tags = WikiFactory::getVarValueByName( self::WIKI_FACTORY_VARIABLE_NAME, $this->wg->CityId );

		$this->response->setVal( 'descriptions', [
			$this->wf->Msg('wikiagameguides-content-description-categories'),
			$this->wf->Msg('wikiagameguides-content-description-tag'),
			$this->wf->Msg('wikiagameguides-content-description-organize')
		] );

		$this->response->setVal( 'addTag', $this->wf->Msg( 'wikiagameguides-content-add-tag' ) );
		$this->response->setVal( 'addCategory', $this->wf->Msg( 'wikiagameguides-content-add-category' ) );
		$this->response->setVal( 'save', $this->wf->Msg( 'wikiagameguides-content-save' ) );

		$this->response->setVal( 'tag_placeholder', $this->wf->Msg( 'wikiagameguides-content-tag' ) );
		$this->response->setVal( 'category_placeholder', $this->wf->Msg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', $this->wf->Msg( 'wikiagameguides-content-name' ) );

		if ( !empty( $tags ) ) {
			$this->response->setVal( 'tags', $tags );
		} else {
			$this->response->setVal( 'tag', $this->sendSelfRequest( 'tag' ) );
			$this->response->setVal( 'category', $this->sendSelfRequest( 'category' ) );
		}

		return true;
	}

	public function tag() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'tag_placeholder', $this->wf->Msg( 'wikiagameguides-content-tag' ) );
	}

	public function category() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'category_placeholder', $this->wf->Msg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', $this->wf->Msg( 'wikiagameguides-content-name' ) );
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
						'title' => $categoryName,
						'id' => $category->getTitle()->getArticleID()
					);

					if ( !empty( $values['name'] ) ) {
						$category['label'] = $values['name'];
					}

					if ( array_key_exists( $values['tag'], $tags ) ) {
						$tags[$values['tag']]['categories'][] = $category;
					} else {
						$tags[$values['tag']] = array(
							'title' => $values['tag'],
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

		$status = WikiFactory::setVarByName( self::WIKI_FACTORY_VARIABLE_NAME, $this->wg->CityId, array_values( $tags ) );
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
