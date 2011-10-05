<?php

class RelatedVideosHookHandler {
	
	const RELATED_VIDEOS_POSITION = 2;

	private $count = 0;
	 
	public function onOutputPageBeforeHTML( &$out, &$text ) {
		if( $out->isArticle() && F::app()->wg->request->getVal( 'diff' ) === null ) {
			$text .= F::app()->sendRequest('RelatedVideosController', 'getCarusel')->toString();
		}
		return true;
	}

	public function onBeforePageDisplay( $out, $skin ) {
		global $wgExtensionsPath, $wgUser, $wgStylePath, $wgStyleVersion;

		wfProfileIn(__METHOD__);
		$skinName = get_class( $wgUser->getSkin() );
		if ($skinName == 'SkinOasis') {
			$out->addScript( "<script src=\"$wgStylePath/common/jquery/jquery.wikia.tooltip.js?{$wgStyleVersion}\"></script>");
			$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/WikiaTooltip.scss' ) );
		}
		
		$out->addScript( '<script src="' . $wgExtensionsPath . '/wikia/RelatedVideos/js/RelatedVideos.js"></script>' );
		$out->addScript( '<script src="' . $wgExtensionsPath . '/wikia/JWPlayer/jwplayer.js"></script>' );
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

		wfDebug(__METHOD__ . "\n");

		$title = $article->getTitle();

		if (!empty($title)) {
			switch ($title->getNamespace()) {
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
}
