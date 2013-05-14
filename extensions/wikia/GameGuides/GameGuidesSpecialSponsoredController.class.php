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

		$this->response->setVal( 'language_placeholder', wfMessage( 'wikiagameguides-sponsored-language' )->text() );
		$this->response->setVal( 'wiki_url_placeholder', wfMessage( 'wikiagameguides-sponsored-wiki-url' )->text() );
		$this->response->setVal( 'video_url_placeholder', wfMessage( 'wikiagameguides-sponsored-video-url' )->text() );
		$this->response->setVal( 'video_title_placeholder', wfMessage( 'wikiagameguides-sponsored-video-title' )->text() );


		$videoTemplate = $this->sendSelfRequest( 'video' )->toString();
		$languageTemplate = $this->sendSelfRequest( 'language' )->toString();

		$this->wg->Out->addJsConfigVars([
			'videoTemplate' => $videoTemplate,
			'languageTemplate' => $languageTemplate
		]);

		$languages = $this->wg->WikiaGameGuidesSponsoredVideos;

		if ( !empty( $languages ) ) {
			$list = '';

			foreach( $languages as $language ) {
				$list .= $this->sendSelfRequest( 'language', [
					'value' => $language['code']
				] );

				if ( !empty( $language['videos'] ) ) {
					foreach( $language['videos'] as $video ) {
						$list .= $this->sendSelfRequest( 'video', [
							'video_url' => $video['video_url'],
							'video_title' => $video['video_title'],
							'wiki_url' => $video['wiki_url']
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

		$this->response->setVal( 'value', $this->request->getVal( 'value' ), '' );

		$this->response->setVal( 'language_placeholder', wfMessage( 'wikiagameguides-sponsored-language' )->text() );
	}

	public function video() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'video_title', $this->request->getVal( 'video_title', '' ) );
		$this->response->setVal( 'video_url', $this->request->getVal( 'video_url'), '' );
		$this->response->setVal( 'wiki_url', $this->request->getVal( 'wiki_url'), '' );

		$this->response->setVal( 'wiki_url_placeholder', wfMessage( 'wikiagameguides-sponsored-wiki-url' )->text() );
		$this->response->setVal( 'video_title_placeholder', wfMessage( 'wikiagameguides-sponsored-video-title' )->text() );
		$this->response->setVal( 'video_url_placeholder', wfMessage( 'wikiagameguides-sponsored-video-url' )->text() );
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
