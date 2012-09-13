<?php
/**
 * Landing Pages Parser
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LandingPagesParser {
	const CACHE_DURATION = 86400;//24h

	private $app;
	private $switches;
	private $magicWords;

	function __construct(){
		$this->app = F::app();
		$this->magicWords = array_keys( $this->app->wg->LandingPagesAsContentMagicWords );


		//singleton
		F::setInstance( __CLASS__, $this );
	}

	public function onLanguageGetMagicHook( &$magicWords, $langCode ){
		foreach ( $this->magicWords as $wordID ) {
			$magicWords[$wordID] = array( 0, $wordID );
		}

		return true;
	}

	public function onInternalParseBeforeLinksHook( &$parser, &$text, &$strip_state ) {
		if ( empty( $this->app->wg->RTEParserEnabled ) ) {
			foreach ( $this->magicWords as $wordID ) {
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
	public function onArticleFromTitle( Title &$title, &$article ) {
		if( $title->exists() &&  $title->getNamespace() !=  NS_FILE && $title->getNamespace() !=  NS_CATEGORY ){
			$key = $this->generateCacheKey( $title->getArticleId() );
			$this->switches = $this->app->wg->memc->get( $key );

			if ( empty( $this->switches ) ) {
				$article = F::build( 'Article', array( $title ) );
				$this->switches = array();

				foreach ( $this->magicWords as $wordID ) {
					$magicWord = MagicWord::get( $wordID );
					$this->switches[$wordID] = ( 0 < $magicWord->match( $article->getRawText() ) );
				}

				$this->app->wg->memc->set( $key, $this->switches, self::CACHE_DURATION );
			}

			$this->process();
		}

		return true;
	}

	/**
	 * @param WikiPage $article
	 * @return bool
	 */
	public function onArticlePurge( &$article ) {
		$this->purgeCache( $article->getID() );

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
	public function onArticleSaveComplete( &$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status,
		$baseRevId, &$redirect = null ) {
 		$this->purgeCache( $article->getID() );

		return true;
	}

	private function process(){
		//TODO: skip in case action=edit?
		foreach ( $this->switches as $wordID => $value ) {
			if ($value == true) {
			$this->app->wg->set( $this->app->wg->LandingPagesAsContentMagicWords[$wordID], $value );
			}
		}

		$this->switches = null;
	}

	private function purgeCache( $articleID ){
		$key = $this->generateCacheKey( $articleID );
		$this->app->wg->memc->delete( $key );
	}

	private function generateCacheKey( $articleID ) {
		return $this->app->wf->memcKey( 'LandingPagesAsContent', $articleID );
	}
}
