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
		switch( $priceConf['period'] ) {
			case 'd': return wfMsgHtml( 'adss-form-usd-per-day', $priceConf['price'] );
			case 'w': return wfMsgHtml( 'adss-form-usd-per-week', $priceConf['price'] );
			case 'm': return wfMsgHtml( 'adss-form-usd-per-month', $priceConf['price'] );
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

	//FIXME temporary hack
	static function flushCache() {
		global $wgMemc, $wgScriptPath;
		$memcKey = wfMemcKey( 'adss', 'siteads' );
		$wgMemc->delete( $memcKey );

		$url = $wgScriptPath . '?action=ajax&rs=AdSS_Publisher::getSiteAdsAjax';
		SquidUpdate::purge( array( $url ) );
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

}
