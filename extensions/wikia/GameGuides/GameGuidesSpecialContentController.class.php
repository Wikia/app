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

		$styles = $assetManager->getURL([
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss'
		]);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL([
			'/extensions/wikia/GameGuides/js/GameGuidesContentManagmentTool.js'
		]);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesContentMsg', JSMessages::INLINE );

		$this->response->setVal( 'descriptions', [
			$this->wf->Msg( 'wikiagameguides-content-description-categories' ),
			$this->wf->Msg( 'wikiagameguides-content-description-tag' ),
			$this->wf->Msg( 'wikiagameguides-content-description-organize' ),
			$this->wf->Msg( 'wikiagameguides-content-description-no-tag' )
		] );

		$this->response->setVal( 'addTag', $this->wf->Msg( 'wikiagameguides-content-add-tag' ) );
		$this->response->setVal( 'addCategory', $this->wf->Msg( 'wikiagameguides-content-add-category' ) );
		$this->response->setVal( 'save', $this->wf->Msg( 'wikiagameguides-content-save' ) );

		$this->response->setVal( 'tag_placeholder', $this->wf->Msg( 'wikiagameguides-content-tag' ) );
		$this->response->setVal( 'category_placeholder', $this->wf->Msg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', $this->wf->Msg( 'wikiagameguides-content-name' ) );


		$categoryTemplate = $this->sendSelfRequest( 'category' )->toString();
		$tagTemplate = $this->sendSelfRequest( 'tag' )->toString();

		$this->wg->Out->addJsConfigVars([
			'categoryTemplate' => $categoryTemplate,
			'tagTemplate' => $tagTemplate
		]);

		$tags = WikiFactory::getVarValueByName( self::WIKI_FACTORY_VARIABLE_NAME, $this->wg->CityId );

		if ( !empty( $tags ) ) {
			$list = '';

			foreach( $tags as $tag ) {
				$list .= $this->sendSelfRequest( 'tag', [
					'value' => $tag['title']
				] );

				if ( !empty( $tag['categories'] ) ) {
					foreach( $tag['categories'] as $category ) {
						$list .= $this->sendSelfRequest( 'category', [
							'category_value' => $category['title'],
							'name_value' => !empty( $category['label'] ) ? $category['label'] : '',
						] );
					}
				}
			}

			$this->response->setVal( 'list', $list );
		} else {
			$this->response->setVal( 'tag', $tagTemplate );
			$this->response->setVal( 'category', $categoryTemplate );
		}

		return true;
	}

	public function tag() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'value', $this->request->getVal('value'), '');
		$this->response->setVal( 'tag_placeholder', $this->wf->Msg( 'wikiagameguides-content-tag' ) );
	}

	public function category() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'category_value', $this->request->getVal('category_value'), '');
		$this->response->setVal( 'name_value', $this->request->getVal('name_value'), '');

		$this->response->setVal( 'category_placeholder', $this->wf->Msg( 'wikiagameguides-content-category' ) );
		$this->response->setVal( 'name_placeholder', $this->wf->Msg( 'wikiagameguides-content-name' ) );
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'gameguidescontent' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$tags = $this->request->getArray( 'tags' );
		$err = [];

		if( !empty( $tags ) ) {
			foreach ( $tags as &$tag ) {

				if( !empty( $tag['categories'] ) ) {

					foreach ( $tag['categories'] as &$cat ) {

						$catTitle = $cat['title'];

						$category = Category::newFromName( $catTitle );
						//check if categories exists
						if ( !( $category instanceof Category ) ) {
							$err[] = $catTitle;
						} else if ( empty( $err ) ) {
							$cat['id'] = $category->getTitle()->getArticleID();
						}
					}
				}
			}

			if ( !empty( $err ) ) {
				$this->response->setVal( 'error', $err );
				return true;
			}
		}

		$status = WikiFactory::setVarByName( self::WIKI_FACTORY_VARIABLE_NAME, $this->wg->CityId, $tags );
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
