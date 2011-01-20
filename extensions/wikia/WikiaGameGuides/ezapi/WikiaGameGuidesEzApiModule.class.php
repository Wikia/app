<?php
/**
 * Wikia Game Guides mobile app EzAPI module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiaGameGuidesEzApiModule extends EzApiModuleBase {
	const WF_WIKI_RECOMMEND_VAR = 'wgWikiaGameGuidesRecommend';
	
	/*
	 * Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikis(){
		global $wgDevelEnvironment;
		wfProfileIn( __METHOD__ );
		
		if( !$wgDevelEnvironment ) {
			$this->requiresPost(); //only POST requests allowed
		}
		wfLoadExtensionMessages( 'WikiaGameGuides' );
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $this->getWikisData() ) );
		
		wfProfileOut( __METHOD__ );
	}
	
	
	/*
	 * Gets a list of recommended wikis through WikiFactory
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	protected function getWikisData(){
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
					'name' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
					'color' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : '#0049C6',
					'backgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : '#FFFFFF',
					'baseUrl' => $wikiUrl,
					'logoUrl'=> ( !empty( $wikiThemeSettings[ 'wordmark-image-url' ] ) ) ? $wikiThemeSettings[ 'wordmark-image-url' ] : null
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
}