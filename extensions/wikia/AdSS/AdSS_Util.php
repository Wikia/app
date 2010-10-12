<?php

class AdSS_Util {

	static function getSitePricing() {
		global $wgAdSS_pricingConf;
		return $wgAdSS_pricingConf['site'];
	}

	static function getPagePricing( $title=null ) {
		global $wgAdSS_pricingConf;

		if( $title ) {
			if( isset( $wgAdSS_pricingConf['page'][$title->getText()] ) ) {
				return $wgAdSS_pricingConf['page'][$title->getText()];
			} elseif( isset( $wgAdSS_pricingConf['page']['#mainpage#'] )
					&& $title->equals( Title::newMainPage() ) ) {
				return $wgAdSS_pricingConf['page']['#mainpage#'];
			} 
		}
		return $wgAdSS_pricingConf['page']['#default#'];
	}

	static function formatPrice( $priceConf ) {
		global $wgLang;
		$price = $priceConf['price'];
		if( intval( $price ) == $price ) {
			$price = intval( $price );
		}
		switch( $priceConf['period'] ) {
			case 'd': return wfMsgHtml( 'adss-form-usd-per-day', $wgLang->formatNum( $price ) );
			case 'w': return wfMsgHtml( 'adss-form-usd-per-week', $wgLang->formatNum( $price ) );
			case 'm': return wfMsgHtml( 'adss-form-usd-per-month', $wgLang->formatNum( $price ) );
		}
	}

	static function formatPriceAjax( $wpType, $wpPage ) {
		global $wgSquidMaxage;
		if( $wpType == 'page' ) {
			$priceConf = self::getPagePricing( Title::newFromText( $wpPage ) );
		} else {
			$priceConf = self::getSitePricing();
		}
		wfLoadExtensionMessages( 'AdSS' );
		$priceStr = self::formatPrice( $priceConf );

		$response = new AjaxResponse( Wikia::json_encode( $priceStr ) );
		$response->setContentType( 'application/json; charset=utf-8' );
		$response->setCacheDuration( $wgSquidMaxage );

		return $response;
	}

	static function flushCache( $pageId=0, $wikiId=0 ) {
		global $wgMemc, $wgServer, $wgScript, $wgArticlePath, $wgCityId;

		$wikiDb = false;
		$wikiServer = false;
		$wikiScript = false;
		$wikiArticlePath = false;

		if( $wikiId > 0 && $wikiId != $wgCityId ) {
			$wiki = WikiFactory::getWikiByID( $wikiId );
			if( !isset( $wiki->city_id ) || $wiki->city_id != $wikiId ) {
				wfDebug( __METHOD__ . ": Wrong wikiId!!\n" );
				return;
			}
			$wikiDb = $wiki->city_dbname;
			$wikiServer = WikiFactory::getVarValueByName( "wgServer", $wikiId );
			$wikiScript = WikiFactory::getVarValueByName( "wgScript", $wikiId );
			$wikiArticlePath = WikiFactory::getVarValueByName( "wgArticlePath", $wikiId );
		}
		$dbw = wfGetDB( DB_MASTER, array(), $wikiDb );
		if( $wikiServer === false ) $wikiServer = $wgServer;
		if( $wikiScript === false ) $wikiScript = $wgScript;
		if( $wikiArticlePath === false ) $wikiArticlePath = $wgArticlePath;

		if( $pageId > 0 ) {
			$title = $dbw->selectField( 
					'page',
					'page_title',
					array( 'page_id' => $pageId )
					);
			
			$dbw->update(
					'page',
					array( 'page_touched' => $dbw->timestamp() ),
					array( 'page_id' => $pageId )
				    );
			wfDebug( __METHOD__ . ": updated page_touched on $wikiDb for page_id=$pageId\n");

			$url = $wikiServer . str_replace( '$1', $title, $wikiArticlePath );
			$memcKey = $dbw->getWikiID() . ":adss:pageads:$pageId";
		} else {
			$url = $wikiServer . $wikiScript . '?action=ajax&rs=AdSS_Publisher::getSiteAdsAjax';
			$memcKey = $dbw->getWikiID() . ":adss:siteads";
		}
		$wgMemc->delete( $memcKey );
		wfDebug( __METHOD__ . ": deleted memcached key $memcKey\n" );
		SquidUpdate::purge( array( $url ) );
		wfDebug( __METHOD__ . ": purged $url\n" );
	}

	static function getToken() {
		wfSetupSession();
		if( !isset( $_SESSION['wsAdSSToken'] ) ) {
			self::generateToken();
		}
		$token = $_SESSION['wsAdSSToken'];
		return $token;
	}

	static function matchToken( $token ) {
		$sessionToken = self::getToken();
		if( $sessionToken != $token ) {
			wfDebug( __METHOD__ . ": broken session data\n" );
		}
		return $sessionToken == $token;
	}

	static function generateToken() {
		$token = dechex( mt_rand() ) . dechex( mt_rand() );
		$_SESSION['wsAdSSToken'] =  md5( $token );
	}

	static function commitAjaxChanges() {
		$factory = wfGetLBFactory();
		$factory->commitMasterChanges();
		$factory->shutdown();
	}

}
