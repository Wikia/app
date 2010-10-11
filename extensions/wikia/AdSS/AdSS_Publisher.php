<?php

class AdSS_Publisher {

	static function getSiteAdsAjax() {
		global $wgSquidMaxage;
		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		$ads = self::getSiteAds();

		$adsRendered = array();
		$minExpire = $wgSquidMaxage + time();
		foreach( $ads as $ad ) {
			$adsRendered[] = $ad->render();
			if( $minExpire > $ad->expires ) {
				$minExpire = $ad->expires;
			}
		}
		$response->addText( Wikia::json_encode( $adsRendered ) );
		$response->setCacheDuration( $minExpire - time() );

		return $response;
	}

	static function getSiteAds() {
		global $wgAdSS_DBname, $wgCityId, $wgMemc, $wgSquidMaxage;

		$memcKey = wfMemcKey( "adss", "siteads" );
		$ads = $wgMemc->get( $memcKey );
		if( $ads === null || $ads === false ) {
			$minExpire = $wgSquidMaxage + time();
			$ads = array();
			$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
			$res = $dbr->select( 'ads', '*', array(
						'ad_wiki_id' => $wgCityId,
						'ad_page_id' => 0,
						'ad_closed' => null,
						'ad_expires > NOW()'
						), __METHOD__ );
			foreach( $res as $row ) {
				$ad = AdSS_Ad::newFromRow( $row );
				if( $minExpire > $ad->expires ) {
					$minExpire = $ad->expires;
				}
				$ads[] = $ad;
			}
			$dbr->freeResult( $res );

			$wgMemc->set( $memcKey, $ads, $minExpire - time() );
		}

		return $ads;
	}

	static function getPageAds( $title ) {
		global $wgMemc, $wgAdSS_DBname, $wgCityId, $wgSquidMaxage;

		if( !self::canShowAds( $title ) ) {
			return array();
		}

		$memcKey = wfMemcKey( "adss", "pageads", $title->getArticleID() );
		$ads = $wgMemc->get( $memcKey );
		if( $ads === null || $ads === false ) {
			$minExpire = $wgSquidMaxage;
			$ads = array();
			$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
			$res = $dbr->select( 'ads', '*', array(
						'ad_wiki_id' => $wgCityId,
						'ad_page_id' => $title->getArticleID(),
						'ad_closed' => null,
						'ad_expires > NOW()'
						), __METHOD__ );
			foreach( $res as $row ) {
				$ad = AdSS_Ad::newFromRow( $row );
				if( $minExpire > $ad->expires ) {
					$minExpire = $ad->expires;
				}
				$ads[] = $ad;
			}
			$dbr->freeResult( $res );

			$wgMemc->set( $memcKey, $ads, $minExpire - time() );
		}

		return $ads;
	}

	static function onOutputPageBeforeHTML( &$out, &$text ) {
		global $wgTitle;
		if( self::canShowAds( $wgTitle ) ) {
			wfLoadExtensionMessages( 'AdSS' );
			$ads = self::getPageAds( $wgTitle );
			
			$selfAd = new AdSS_Ad();
			$selfAd->url = str_replace( 'http://', '', SpecialPage::getTitleFor( 'AdSS')->getFullURL( 'page='.$wgTitle->getText() ) );
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
		if( self::canShowAds( $wgTitle ) ) {
			wfLoadExtensionMessages( 'AdSS' );
			$ads = self::getPageAds( $wgTitle );
			
			$selfAd = new AdSS_Ad();
			$selfAd->url = str_replace( 'http://', '', SpecialPage::getTitleFor( 'AdSS')->getFullURL( 'page='.$wgTitle->getText() ) );
			$selfAd->text = wfMsg( 'adss-ad-default-text' );
			$selfAd->desc = wfMsg( 'adss-ad-default-desc' );

			$vars['wgAdSS_pageAds'] = array();
			foreach( $ads as $ad ) {
				$vars['wgAdSS_pageAds'][] = $ad->render();
			}
			$vars['wgAdSS_selfAd'] = $selfAd->render();
		}
		return true;
	}

	static function onAjaxAddScript( &$out ) {
		global $wgStyleVersion, $wgJsMimeType, $wgExtensionsPath, $wgTitle;
		if( self::canShowAds( $wgTitle ) ) {
			$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/AdSS/adss.js?{$wgStyleVersion}\"></script>\n" );
		}
		return true;
	}

	static function canShowAds( $title ) {
		global $wgUser;
		return  !$wgUser->isLoggedIn() &&
			isset( $title ) && is_object( $title ) &&
			$title->exists() &&
			$title->getNamespace() == NS_MAIN &&
			!$title->equals( Title::newMainPage() );
	}

	static function onOutputPageCheckLastModified( &$modifiedTimes ) {
		global $wgTitle;

		if( self::canShowAds( $wgTitle ) ) {
			$now = time();
			$ads = self::getPageAds( $wgTitle->getArticleID() );
			foreach( $ads as $ad ) {
				if( $ad->expires < $now ) {
					$modifiedTimes['adss'] = wfTimestamp( TS_MW, $now );	
				}
			}
		}
		return true;
	}

	static function onArticlePurge( &$article ) {
		global $wgMemc;
		if( self::canShowAds( $article->mTitle ) ) {
			$wgMemc->delete( wfMemcKey( 'adss', 'pageads', $article->mTitle->getArticleID() ) );
		}
		return true;
	}

}
