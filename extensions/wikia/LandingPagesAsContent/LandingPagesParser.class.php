<?php
/**
 * Landing Pages Parser
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LandingPagesParser {
	const CACHE_DURATION = 86400;//24h

	static private $switches;

	static public function onLanguageGetMagicHook( &$magicWords, $langCode ){
		global $wgLandingPagesAsContentMagicWords;
		$landingMagicWords = array_keys( $wgLandingPagesAsContentMagicWords );
		foreach ( $landingMagicWords as $wordID ) {
			$magicWords[$wordID] = array( 0, $wordID );
		}

		return true;
	}

	static public function onInternalParseBeforeLinksHook( &$parser, &$text, &$strip_state ) {
		global $wgLandingPagesAsContentMagicWords, $wgRTEParserEnabled;
		if ( empty( $wgRTEParserEnabled ) ) {
			$magicWords = array_keys( $wgLandingPagesAsContentMagicWords );
			foreach ( $magicWords as $wordID ) {
				MagicWord::get( $wordID )->matchAndRemove( $text );
			}
		}

		return true;
	}

	/**
	 * @param Title $title
	 * @param WikiPage $article
	 * @return bool
	 */
	static public function onArticleFromTitle( Title &$title, &$article ) {
		global $wgLandingPagesAsContentMagicWords;
		$app = F::app();

		if( $title->exists() &&  $title->getNamespace() !=  NS_FILE && $title->getNamespace() !=  NS_CATEGORY ){
			$key = self::generateCacheKey( $title->getArticleId() );
			self::$switches = $app->wg->memc->get( $key );

			if ( empty( self::$switches ) ) {
				$article = new Article( $title );
				self::$switches = array();

				$magicWords = array_keys( $wgLandingPagesAsContentMagicWords );

				foreach ( $magicWords as $wordID ) {
					$magicWord = MagicWord::get( $wordID );
					self::$switches[$wordID] = ( 0 < $magicWord->match( $article->getRawText() ) );
				}

				$app->wg->memc->set( $key, self::$switches, self::CACHE_DURATION );
			}

			self::process();
		}

		return true;
	}

	/**
	 * @param WikiPage $article
	 * @return bool
	 */
	static public function onArticlePurge( &$article ) {
		self::purgeCache( $article->getID() );

		return true;
	}

	/**
	 * @param WikiPage $article
	 * @param $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @param null $redirect
	 * @return bool
	 */
	static public function onArticleSaveComplete( &$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status,
		$baseRevId, &$redirect = null ) {
 		self::purgeCache( $article->getID() );

		return true;
	}

	static private function process(){
		global $wgLandingPagesAsContentMagicWords;
		//TODO: skip in case action=edit?
		foreach ( self::$switches as $wordID => $value ) {
			if ($value == true) {
				$GLOBALS[ $wgLandingPagesAsContentMagicWords[$wordID] ] = $value;
			}
		}

		self::$switches = null;
	}

	static private function purgeCache( $articleID ){
		global $wgMemc;
		$key = self::generateCacheKey( $articleID );
		$wgMemc->delete( $key );
	}

	static private function generateCacheKey( $articleID ) {
		return wfmemcKey( 'LandingPagesAsContent', $articleID );
	}
}
