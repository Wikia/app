<?php

/**
 * @deprecated
 */
class GameGuidesSpecialSponsoredController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const VIDEO_DOES_NOT_EXIST = 1;
	const VIDEO_IS_NOT_PROVIDED_BY_OOYALA = 2;

	public function __construct() {
		parent::__construct( 'GameGuidesSponsored', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'gameguidessponsored' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = wfMsg( 'wikiagameguides-sponsored-title' );
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

		JSMessages::enqueuePackage( 'GameGuidesSponsoredMsg', JSMessages::INLINE );

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

			foreach( $languages as $lang => $videos ) {
				$list .= $this->sendSelfRequest( 'language', [
					'value' => $lang
				] );

				foreach( $videos as $video ) {
					$list .= $this->sendSelfRequest( 'video', [
						'video_name' => $video['video_name'],
						'video_title' => $video['video_title'],
						'wiki' => $video['wiki_domain']
					] );
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
		$this->response->setVal( 'video_name', $this->request->getVal( 'video_name', '' ) );
		$this->response->setVal( 'wiki', $this->request->getVal( 'wiki', '') );

		$this->response->setVal( 'wiki_url_placeholder', wfMessage( 'wikiagameguides-sponsored-wiki-url' )->text() );
		$this->response->setVal( 'video_title_placeholder', wfMessage( 'wikiagameguides-sponsored-video-title' )->text() );
		$this->response->setVal( 'video_name_placeholder', wfMessage( 'wikiagameguides-sponsored-video-name' )->text() );
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'gameguidessponsored' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setFormat( 'json' );

		$languages = $this->request->getArray( 'languages' );
		$err = [];

		if( !empty( $languages ) ) {
			foreach ( $languages as $lang => $videos ) {
				foreach ( $videos as $key => $video) {

					$wikiId = (int) WikiFactory::DomainToID( $video['wiki_domain'] );

					$video['wiki_id'] = $wikiId;

					$wiki = WikiFactory::getWikiByID( $wikiId );

					$video['wiki_name'] = $wiki->city_title;
					$video['wiki_lang'] = $wiki->city_lang;

					$title = Title::newFromText( $video['video_name'], NS_FILE );

					if ( !empty( $title ) && $title->exists() ) {
						$vid = wfFindFile( $title );

						if ( !empty( $vid ) && $vid instanceof WikiaLocalFile ) {

							$handler = $vid->getHandler();

							if ( $handler instanceof OoyalaVideoHandler ) {
								$metadata = $handler->getVideoMetadata( true );

								$video['video_id'] = $metadata['videoId'];
								$video['duration'] = WikiaFileHelper::formatDuration( $metadata['duration'] );
								$video['video_thumb'] = WikiaFileHelper::getMediaDetail( $title )['imageUrl'];
							} else{
								$err[$video['video_name']] = self::VIDEO_IS_NOT_PROVIDED_BY_OOYALA;
							}
						} else {
							$err[$video['video_name']] = self::VIDEO_DOES_NOT_EXIST;
						}
					} else {
						$err[$video['video_name']] = self::VIDEO_DOES_NOT_EXIST;
					}

					$videos[$key] = $video;
				}

				$languages[$lang] = $videos;
			}
		}

		if ( !empty( $err ) ) {
			$this->response->setVal( 'error', $err );
		} else {
			$status = WikiFactory::setVarByName( 'wgWikiaGameGuidesSponsoredVideos', $this->wg->CityId, $languages );
			$this->response->setVal( 'status', $status );

			if ( $status ) {
				wfRunHooks( 'GameGuidesSponsoredVideosSave' );
			}
		}

		return true;
	}
}
