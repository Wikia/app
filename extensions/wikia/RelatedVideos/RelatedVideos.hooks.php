<?php

class RelatedVideosHookHandler {

	const RELATED_VIDEOS_POSITION = 2;

	public function onOutputPageBeforeHTML( OutputPage &$out, &$text ) {
		wfProfileIn(__METHOD__);

		if( $out->isArticle() && F::app()->wg->request->getVal( 'diff' ) === null && ( F::app()->wg->title->getNamespace() == NS_MAIN ) ) {
			$text .= F::app()->sendRequest('RelatedVideos', 'getCarusel')->toString();
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function onBeforePageDisplay( OutputPage $out, $skin ) {
		wfProfileIn(__METHOD__);

		if( F::app()->checkSkin( 'oasis', $skin ) ) {
			$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );
			$scssPackage = 'relatedvideos_scss';
			$jsPackage = 'relatedvideos_js';

			foreach ( $assetsManager->getURL( $scssPackage ) as $url ) {
				$out->addStyle( $url );
			}

			foreach ( $assetsManager->getURL( $jsPackage ) as $url ) {
				$out->addScript( "<script src=\"{$url}\"></script>" );
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	 /**
	  * Purge RelatedVideos namespace article after an edit
	  *
	  * @param WikiPage $article
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

		if( $title->exists() && $app->wg->request->getVal( 'diff' ) === null
			&& ( $namespace == NS_MAIN || $namespace == NS_FILE || $namespace == NS_CATEGORY
				|| ( (!empty($app->wg->ContentNamespace)) && in_array($namespace, $app->wg->ContentNamespace) ) ) ) {
			$pos = $app->wg->User->isAnon() ? 1301 : 1281;
			$modules[$pos] = array('RelatedVideosRail', 'index', null);
		}

		$app->wf->ProfileOut(__METHOD__);
		return true;
	}
}
