<?php
/**
 * MobileApiRecommendedContent module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class MobileApiRecommendedContent extends MobileApiBase {
	const WF_WIKI_RECOMMEND_VAR = 'wgMobileApiWikiRecommend';
	const WF_WIKI_CATEGORY_VAR = 'wgMobileApiWikiCategory';
	
	/*
	 * Gets a list of recommended wikis through WikiFactory
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getRecommendedWikis(){
		wfProfileIn( __METHOD__ );
		
		//if ( $request->wasPosted() ) {
			wfLoadExtensionMessages( 'MobileApp' );
			$ret = Array();
			
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_WIKI_RECOMMEND_VAR, null );
			
			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );
				
				foreach( $recommendedIds as $wikiId ) {
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
					//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
					$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
					
					$ret[] = Array(
						'name' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
						//'font' => ( !empty( $wikiThemeSettings[ 'wordmark-font' ] ) ) ? $wikiThemeSettings[ 'wordmark-font' ] : null,
						'color' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : '#0049C6',
						'backgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : '#FFFFFF',
						'homeUrl' => $wikiUrl,
						'logoUrl'=> ( !empty( $wikiThemeSettings[ 'wordmark-image-url' ] ) ) ? $wikiThemeSettings[ 'wordmark-image-url' ] : null
						//,'data' => var_dump( $wikiThemeSettings, true )//debug only
					);
				}
			}
			
			$this->setResponseContentType( 'application/json; charset=utf-8' );
			$this->setResponseContent( Wikia::json_encode( $ret ) );
		//}
		
		wfProfileOut( __METHOD__ );
	}
}