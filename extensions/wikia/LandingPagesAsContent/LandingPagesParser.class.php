<?php
/**
 * Landing Pages Parser
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */

class LandingPagesParser {
	private $config = array(
		__NORAIL__ => 'wgSuppressRail',
		__NONAV__ => 'wgSuppressWikiHeader',
		__NOHEADER__ => 'wgSuppressPageHeader'
	);
	
	private $app;
	private $switches;
	private $magicWords;
	
	function __construct(){
		$this->app = F::app();
		$this->magicWords = array_keys( $this->config );
		
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
	
	public function onArticleFromTitle( &$title, &$article ) {
		$article = F::build( 'Article', array( $title ) );
		$this->switches = array();
		
		foreach ( $this->magicWords as $wordID ) {
			$magicWord = MagicWord::get( $wordID );
			$this->switches[$wordID] = ( 0 < $magicWord->match( $article->getRawText() ) );
		}
		
		$this->process();
		
		return true;
	}
	
	public function process(){
		//TODO: skip in case action=edit?
		foreach ( $this->switches as $wordID => $value ) {
			$this->app->wg->set( $this->config[$wordID], $value );
		}
		
		$this->switches = null;
	}
}