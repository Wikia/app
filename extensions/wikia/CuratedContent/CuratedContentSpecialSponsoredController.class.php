<?php

class CuratedContentSpecialSponsoredController extends WikiaSpecialPageController {

	const TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const VIDEO_DOES_NOT_EXIST = 1;
	const VIDEO_IS_NOT_PROVIDED_BY_OOYALA = 2;

	public function __construct() {
		parent::__construct( 'CuratedContentSponsored', '', false );
	}

	public function index() {
		if (!$this->wg->User->isAllowed( 'CuratedContentsponsored' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$title = wfMsg( 'wikiaCuratedContent-sponsored-title' );
		$this->wg->Out->setPageTitle( $title );
		$this->wg->Out->setHTMLTitle( $title );

		$this->wg->Out->addModules([
			'jquery.autocomplete',
			'jquery.ui.sortable',
		]);

		$assetManager = AssetsManager::getInstance();

		$styles = $assetManager->getURL([
			'extensions/wikia/CuratedContent/css/CuratedContentContentManagmentTool.scss'
		]);

		foreach( $styles as $s ) {
			$this->wg->Out->addStyle( $s );
		}

		$scripts = $assetManager->getURL([
			'/extensions/wikia/CuratedContent/js/CuratedContentSponsored.js'
		]);

		foreach( $scripts as $s ) {
			$this->wg->Out->addScriptFile( $s );
		}

		JSMessages::enqueuePackage( 'CuratedContentSponsoredMsg', JSMessages::INLINE );

		$this->response->setVal( 'descriptions', [
			wfMessage( 'wikiaCuratedContent-sponsored-description-language' )->text(),
			wfMessage( 'wikiaCuratedContent-sponsored-description-wiki' )->text(),
			wfMessage( 'wikiaCuratedContent-sponsored-description-title' )->text(),
			wfMessage( 'wikiaCuratedContent-sponsored-description-url' )->text(),
		] );

		$this->response->setVal( 'addTag', wfMessage( 'wikiaCuratedContent-sponsored-add-language' )->text() );
		$this->response->setVal( 'addCategory', wfMessage( 'wikiaCuratedContent-sponsored-add-video' )->text() );
		$this->response->setVal( 'save', wfMessage( 'wikiaCuratedContent-content-save' )->text() );

		$this->response->setVal( 'language_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-language' )->text() );
		$this->response->setVal( 'wiki_url_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-wiki-url' )->text() );
		$this->response->setVal( 'video_url_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-video-url' )->text() );
		$this->response->setVal( 'video_title_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-video-title' )->text() );


		$videoTemplate = $this->sendSelfRequest( 'video' )->toString();
		$languageTemplate = $this->sendSelfRequest( 'language' )->toString();

		$this->wg->Out->addJsConfigVars([
			'videoTemplate' => $videoTemplate,
			'languageTemplate' => $languageTemplate
		]);

		$languages = $this->wg->WikiaCuratedContentSponsoredVideos;

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

		$this->response->setVal( 'language_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-language' )->text() );
	}

	public function video() {
		$this->response->setTemplateEngine( self::TEMPLATE_ENGINE );

		$this->response->setVal( 'video_title', $this->request->getVal( 'video_title', '' ) );
		$this->response->setVal( 'video_name', $this->request->getVal( 'video_name', '' ) );
		$this->response->setVal( 'wiki', $this->request->getVal( 'wiki', '') );

		$this->response->setVal( 'wiki_url_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-wiki-url' )->text() );
		$this->response->setVal( 'video_title_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-video-title' )->text() );
		$this->response->setVal( 'video_name_placeholder', wfMessage( 'wikiaCuratedContent-sponsored-video-name' )->text() );
	}

	public function save(){
		if ( !$this->wg->User->isAllowed( 'CuratedContentsponsored' ) ) {
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
								$metadata = $handler->getMetadata( true );

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
			$status = WikiFactory::setVarByName( 'wgWikiaCuratedContentSponsoredVideos', $this->wg->CityId, $languages );
			$this->response->setVal( 'status', $status );

			if ( $status ) {
				wfRunHooks( 'CuratedContentSponsoredVideosSave' );
			}
		}

		return true;
	}
}
