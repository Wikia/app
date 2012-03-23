<?php

class RelatedVideosHookHandler {
	
	const RELATED_VIDEOS_POSITION = 2;

	private $count = 0;
	 
	public function onOutputPageBeforeHTML( &$out, &$text ) {
		wfProfileIn(__METHOD__);
		
		if( $out->isArticle() && F::app()->wg->request->getVal( 'diff' ) === null && ( F::app()->wg->title->getNamespace() == NS_MAIN ) ) {
			$text .= F::app()->sendRequest('RelatedVideosController', 'getCarusel')->toString();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function onBeforePageDisplay( $out, $skin ) {
		wfProfileIn(__METHOD__);
		
		$skinName = get_class( F::app()->wg->user->getSkin() );
		if ($skinName == 'SkinOasis') {
			$out->addScript( '<script src="' . F::app()->wg->stylePath . '/common/jquery/jquery.wikia.tooltip.js?' . F::app()->wg->styleVersion . '"></script>');
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/WikiaTooltip.scss' ) );
		}
		
		$out->addScript( '<script src="' . F::app()->wg->extensionsPath . '/wikia/RelatedVideos/js/RelatedVideos.js"></script>' );
		$out->addScript( '<script src="' . F::app()->wg->extensionsPath . '/wikia/JWPlayer/jwplayer.min.js"></script>' );	//@todo post-migration, might be able to remove this
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/RelatedVideos/css/RelatedVideos.scss' ) );

		wfProfileOut(__METHOD__);
		return true;
	}

	public static function onOutputPageMakeCategoryLinks( $outputPage, $categories, $categoryLinks ) {
		RelatedVideos::getInstance()->setCategories( $categories );
		return true;
	}
	
	 /**
	 * Purge RelatedVideos namespace article after an edit
	 */
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		wfProfileIn(__METHOD__);

		$title = $article->getTitle();

		if ( !empty( $title ) ) {
			switch ( $title->getNamespace() ) {
				case NS_RELATED_VIDEOS:
					$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle($title);
					$relatedVideosNSData->purge();
					break;
				case NS_MEDIAWIKI:
					if ( empty( F::app()->wg->relatedVideosPartialRelease ) ){
						if ( $title->getText() == RelatedVideosNamespaceData::GLOBAL_RV_LIST ){
							$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle($title);
							$relatedVideosNSData->purge();
						}
					}
				break;
			}
		}
			
		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Entry for adding parser magic words
	 */
	static public function onLanguageGetMagic( &$magicWords, $langCode ){
		wfProfileIn(__METHOD__);

		$magicWords[ 'RELATEDVIDEOS_POSITION' ] = array( 0, '__RELATEDVIDEOS__' );

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Entry for removing the magic words from displayed text
	 */
	static public function onInternalParseBeforeLinks( &$parser, &$text, &$strip_state ) {
		global $wgRelatedVideosOnRail;
		wfProfileIn(__METHOD__);

		if ( empty( F::app()->wg->RTEParserEnabled ) ) {
			$oMagicWord = MagicWord::get('RELATEDVIDEOS_POSITION');
			$text = $oMagicWord->replace('<span data-placeholder="RelatedVideosModule"></span>', $text, 1 );
			$text = $oMagicWord->replace( '', $text );
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	public function onGetRailModuleList(&$modules) {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		
		$title = $app->wg->Title;
		$namespace = $title->getNamespace();
		
		if( $title->exists() && $app->wg->request->getVal( 'diff' ) === null && ( $namespace == NS_MAIN ) ) {
			$pos = $app->wg->User->isAnon() ? 1301 : 1281;
			$modules[$pos] = array('RelatedVideosRailModule', 'index', null);
		}
		
		$app->wf->ProfileOut(__METHOD__);
		return true;
	}
	
	
	
}
