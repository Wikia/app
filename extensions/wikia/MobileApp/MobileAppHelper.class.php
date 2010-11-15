<?php
/**
 * MobileAppHelper
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class MobileAppHelper {
	/*
	 * Gets a list of recommended wikis through WikiFactory
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	//http://muppets.federico.wikia-dev.com/index.php?action=ajax&rs=MobileAppHelper::getRecommendedWikis
	public static function getRecommendedWikis(){
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		
		//if ( $wgRequest->wasPosted() ) {
			wfLoadExtensionMessages( 'MobileApp' );
			$ret = Array();
			
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( MOBILEAPP_WF_RECOMMEND_VAR, null );
			
			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );
				
				foreach( $recommendedIds as $wikiId ) {
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
					//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
					$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
					
					$ret[] = Array(
						//'title' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
						//'font' => ( !empty( $wikiThemeSettings[ 'wordmark-font' ] ) ) ? $wikiThemeSettings[ 'wordmark-font' ] : null,
						'color' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : null,
						'backgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : null,
						'homeUrl' => $wikiUrl,
						'leftImage'=> ( !empty( $wikiThemeSettings[ 'wordmark-image-url' ] ) ) ? $wikiThemeSettings[ 'wordmark-image-url' ] : null,
						'indentionLevel' => '2'
						//,'data' => var_dump( $wikiThemeSettings, true )//debug only
					);
				}
			}
			
			$json = Wikia::json_encode( $ret );
			$response = new AjaxResponse( $json );
			$response->setContentType( 'application/json; charset=utf-8' );
			
			wfProfileOut( __METHOD__ );
			return $response;
		/*}
		
		wfProfileOut( __METHOD__ );*/
	}
}