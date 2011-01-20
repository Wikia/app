<?php
/**
 * Wikia Game Guides mobile app EzAPI module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiaGameGuidesEzApiModule extends EzApiModuleBase {
	const WF_WIKI_RECOMMEND_VAR = 'wgWikiaGameGuidesRecommend';
	
	function __construct( WebRequest $request ) {
		global $wgDevelEnvironment;
		
		if( !$wgDevelEnvironment ) {
			$this->setRequiresPost( true ); //only POST requests allowed
		}
		
		parent::__construct( $request );
	}
	
	/*
	 * Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikis(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->getWikisList();
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikiContents(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->getWikiContents();
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $this->getWikiContents() ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Gets a list of recommended wikis through WikiFactory
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	private function getWikisList(){
		wfProfileIn( __METHOD__ );
		
		$ret = Array();
		
		$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_WIKI_RECOMMEND_VAR, null );
		
		if ( !empty( $wikiFactoryRecommendVar ) ) {
			$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );
			
			foreach( $recommendedIds as $wikiId ) {
				//TODO: check if optimizable with one query via Ops
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
				//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
				$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
				
				$ret[] = Array(
					'wikiName' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
					'wordmarkColor' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : '#0049C6',
					'wordmarkBackgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : '#FFFFFF',
					'wikiUrl' => $wikiUrl,
					'wordmarkUrl'=> ( !empty( $wikiThemeSettings[ 'wordmark-image-url' ] ) ) ? $wikiThemeSettings[ 'wordmark-image-url' ] : null
					//,'data' => var_dump( $wikiThemeSettings, true )//debug only
				);
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new EzApiException( 'WikiFactory variable \'' . self::WF_WIKI_RECOMMEND_VAR . '\' not found' );
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns a structure representing application-related content on for the current wiki
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	private function getWikiContents(){
		wfProfileIn( __METHOD__ );
		
		$ret = Array();
		
		foreach ( $this->getTabsLabels() as $tab ) {
			$ret[] = $this->getCategoryInfo( $tab );
		}
		
		$ret[] = $this->getMoreCategoriesInfo();
		
		return $ret;
		
		wfProfileOut( __METHOD__ );
	}
	
	/*
	 * Gets the values of the tab messages which are names for real categories, except the last one
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	private function getTabsLabels(){
		wfLoadExtensionMessages( 'WikiaGameGuides' );
		
		return array(
			wfMsgForContent( 'wikiagameguides-tab-1' ),
			wfMsgForContent( 'wikiagameguides-tab-2' ),
			wfMsgForContent( 'wikiagameguides-tab-3' ),
		);
	}
	
	/*
	 * Gets data for the per-category tabs
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	private function getCategoryInfo( $categoryName ) {
		$categoryName = trim( $categoryName );
		$category = Category::newFromName( $categoryName );
		
		$ret = Array(
			'name' => $categoryName,
			'items' => Array()
		);
		
		if ( $category ) {
			$ret[ 'name' ] = $category->getTitle()->getText();
			$titles = $category->getMembers();
			
			foreach( $titles as $title ) {
				$ret[ 'items' ][] = Array(
					'name' => $title->getText(),
					//TODO: replace temporary solution to reach the App skin
					'url' => $title->getLocalUrl( array( 'useskin' => 'wikiaapp' ) )
				);
			}
		}
		
		return $ret;
	}
	
	/*
	 * Gets data for the "More" tab
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	private function getMoreCategoriesInfo(){
		wfLoadExtensionMessages( 'WikiaGameGuides' );
		
		$ret = Array(
			'name' => wfMsgForContent( 'wikiagameguides-tab-more' ),
			'items' => Array()
		);
		
		$categories = array_filter(
			explode( "\n", wfMsgForContent( 'wikiagameguides-tab-more-content' ) ),
			array( __CLASS__, 'verifyElement')
		);
		
		foreach ( $categories as $categoryName ) {
			$category = Category::newFromName( $categoryName );
			
			if ( $category ) {
				$title = $category->getTitle();
				
				$ret[ 'items' ][] = Array(
					'name' => $title->getText(),
					//TODO: replace temporary solution to reach the App skin
					'url' => $title->getLocalUrl( array( 'useskin' => 'wikiaapp' ) )
				);
			}
		}
		
		return $ret;
	}
	
	public static function verifyElement( $elem ){
		$elem = trim( $elem );
		return !empty( $elem );
	}
}