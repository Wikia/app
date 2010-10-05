<?php

class AdSS_Publisher {

	static function getSiteAdsAjax() {
		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		$ads = self::getSiteAds();

		$adsRendered = array();
		$minExpire = 0;
		foreach( $ads as $ad ) {
			$adsRendered[] = $ad->render();
			if( $minExpire == 0  || $minExpire > $ad->expires ) {
				$minExpire = $ad->expires;
			}
		}
		$response->addText( Wikia::json_encode( $adsRendered ) );
		$response->setCacheDuration( $minExpire - time() );

		return $response;
	}

	static function getSiteAds() {
		global $wgAdSS_DBname, $wgCityId, $wgMemc;

		$ads = array();

		$memcKey = "adss:siteads";
		$ads = $wgMemc->get( $memcKey );
		if( $ads === null || $ads === false ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
			$res = $dbr->select( 'ads', '*', array(
						'ad_wiki_id' => $wgCityId,
						'ad_page_id' => 0,
						'ad_closed' => null,
						'ad_expires > NOW()'
						), __METHOD__ );
			foreach( $res as $row ) {
				$ads[] = AdSS_Ad::newFromRow( $row );
			}
			$dbr->freeResult( $res );

			//TODO maybe provide an expire time?
			$wgMemc->set( $memcKey, $ads );
		}

		return $ads;
	}

	static function getPageAds( $title ) {
		global $wgAdSS_DBname, $wgCityId;

		$ads = array();
		//TODO re-introduce later
		return $ads;

		//FIXME add memcached
		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$res = $dbr->select( 'ads', '*', array(
					'ad_wiki_id' => $wgCityId,
					'ad_page_id' => $title->getArticleID(),
					'ad_closed' => null,
					'ad_expires > NOW()'
					), __METHOD__ );
		foreach( $res as $row ) {
			$ads[] = AdSS_Ad::newFromRow( $row );
		}
		$dbr->freeResult( $res );

		return $ads;
	}

	static function onOutputPageBeforeHTML( &$out, &$text ) {
		global $wgTitle;
		if( self::canShowAds() && $wgTitle->exists() ) {
			wfLoadExtensionMessages( 'AdSS' );
			$ads = self::getPageAds( $wgTitle );
			
			$selfAd = new AdSS_Ad();
			$selfAd->url = str_replace( 'http://', '', SpecialPage::getTitleFor( 'AdSS')->getFullURL() );
			$selfAd->text = wfMsg( 'adss-ad-default-text' );
			$selfAd->desc = wfMsg( 'adss-ad-default-desc' );

			$text .= wfMsgWikiHtml( 'adss-ad-header' );
			$text .= Xml::openElement( 'ul', array( 'class' => 'adss' ) );
			foreach( $ads as $ad ) {
				$text .= $ad->render();
			}
			$text .= $selfAd->render();
			$text .= Xml::closeElement( 'ul' );
		}
		return true;
	}

	static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgTitle;
		if( self::canShowAds() && $wgTitle->exists() ) {
			wfLoadExtensionMessages( 'AdSS' );
			$ads = self::getPageAds( $wgTitle );
			
			$selfAd = new AdSS_Ad();
			$selfAd->url = str_replace( 'http://', '', SpecialPage::getTitleFor( 'AdSS')->getFullURL() );
			$selfAd->text = wfMsg( 'adss-ad-default-text' );
			$selfAd->desc = wfMsg( 'adss-ad-default-desc' );

			$vars['wgAdSS_siteAds'] = array();
			foreach( $ads as $ad ) {
				$vars['wgAdSS_siteAds'][] = $ad->render();
			}
			$vars['wgAdSS_selfAd'] = $selfAd->render();
		}
		return true;
	}

	static function onAjaxAddScript( &$out ) {
		global $wgExtensionsPath;
		if( self::canShowAds() ) {
			$out->addScriptFile( $wgExtensionsPath."/wikia/AdSS/adss.js" );
		}
		return true;
	}

	static function canShowAds() {
		global $wgUser, $wgTitle;
		return  !$wgUser->isLoggedIn() &&
			isset( $wgTitle ) && is_object( $wgTitle ) &&
			$wgTitle->getNamespace() == NS_MAIN &&
			!$wgTitle->equals( Title::newMainPage() );
	}

}
