<?php

class GameGuidesSpecialSponsoredController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'GameGuidesSponsored', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidessponsored' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = $this->wf->Msg( 'wikiagameguides-sponsored-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules([
			'jquery.autocomplete',
			'jquery.ui.sortable',
		]);

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL([
			'extensions/wikia/GameGuides/css/GameGuidesContentManagmentTool.scss'
		]);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL([
			'/extensions/wikia/GameGuides/js/GameGuidesSponsored.js'
		]);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		F::build( 'JSMessages' )->enqueuePackage( 'GameGuidesSponsoredMsg', JSMessages::INLINE );

		$this->response->setVal( 'descriptions', [
			wfMessage( 'wikiagameguides-sponsored-description-language' )->text(),
			wfMessage( 'wikiagameguides-sponsored-description-wiki' )->text(),
			wfMessage( 'wikiagameguides-sponsored-description-title' )->text(),
			wfMessage( 'wikiagameguides-sponsored-description-url' )->text(),
		] );

		$this->response->setVal( 'addTag', wfMessage( 'wikiagameguides-sponsored-add-language' )->text() );
		$this->response->setVal( 'addCategory', wfMessage( 'wikiagameguides-sponsored-add-video' )->text() );
		$this->response->setVal( 'save', wfMessage( 'wikiagameguides-content-save' )->text() );

		$this->response->setVal( 'tag_placeholder', wfMessage( 'wikiagameguides-sponsored-language' )->text() );
		$this->response->setVal( 'category_placeholder', wfMessage( 'wikiagameguides-sponsored-video' )->text() );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiagameguides-sponsored-title' )->text() );


		$videoTemplate = $this->sendSelfRequest( 'video' )->toString();
		$languageTemplate = $this->sendSelfRequest( 'language' )->toString();

		$this->wg->Out->addJsConfigVars([
			'videoTemplate' => $videoTemplate,
			'languageTemplate' => $languageTemplate
		]);

		$tags = $this->wg->WikiaGameGuidesSponsoredVideos;

		if ( !empty( $tags ) ) {
			$list = '';

			foreach( $tags as $tag ) {
				$list .= $this->sendSelfRequest( 'language', [
					'value' => $tag['title'],
					'image_id' => $tag['image_id']
				] );

				if ( !empty( $tag['categories'] ) ) {
					foreach( $tag['categories'] as $category ) {
						$list .= $this->sendSelfRequest( 'video', [
							'category_value' => $category['title'],
							'name_value' => !empty( $category['label'] ) ? $category['label'] : '',
							'image_id' => $category['image_id']
						] );
					}
				}
			}

			$this->response->setVal( 'list', $list );
		}

		return true;
	}

	public function language() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );

		$this->response->setVal( 'value', $this->request->getVal( 'value' ), '' );
		$this->response->setVal( 'image_id', $id );
		$this->response->setVal( 'image_url', '' );
		if ( $id != 0 ) {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'tag_placeholder', wfMessage( 'wikiagameguides-content-tag' )->text() );
	}

	public function video() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$id = $this->request->getVal( 'image_id', 0 );
		$category = $this->request->getVal( 'category_value', '' );

		$this->response->setVal( 'category_value', $category );
		$this->response->setVal( 'name_value', $this->request->getVal('name_value'), '' );
		$this->response->setVal( 'image_id', $id );


		if ( $id == 0 && $category != '' ) {
			$cat = Title::newFromText( $category, NS_CATEGORY );

			if ( $cat instanceof Title ) {
				$id = $cat->getArticleID();
			}
		} else {
			$this->response->setVal( 'image_set', true );
		}

		$this->response->setVal( 'image_url', 'asd' );
		$this->response->setVal( 'category_placeholder', wfMessage( 'wikiagameguides-content-category' )->text() );
		$this->response->setVal( 'name_placeholder', wfMessage( 'wikiagameguides-content-name' )->text() );
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'gameguidessponsored' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		$this->response->setFormat( 'json' );

		$tags = $this->request->getArray( 'tags' );
		$err = [];

		if( !empty( $tags ) ) {
			foreach ( $tags as &$tag ) {

				$tag['image_id'] = (int) $tag['image_id'];

				if( !empty( $tag['categories'] ) ) {

					foreach ( $tag['categories'] as &$cat ) {

						$catTitle = $cat['title'];

						$cat['image_id'] = (int) $cat['image_id'];

						$category = Category::newFromName( $catTitle );
						//check if categories exists
						if ( !( $category instanceof Category ) || $category->getPageCount() === 0 ) {
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

		$status = WikiFactory::setVarByName( 'wgWikiaGameGuidesSponsoredVideos', $this->wg->CityId, $tags );
		$this->response->setVal( 'status', $status );

		if ( $status ) {
			$this->wf->RunHooks( 'GameGuidesSponsoredVideosSave' );
		}

		return true;
	}
}
