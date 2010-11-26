<?php

class AdSS_Publisher {

	static function getSiteAdsAjax() {
		global $wgSquidMaxage, $wgAdSS_templatesDir;
		$response = new AjaxResponse();
		$response->setContentType( 'application/json; charset=utf-8' );

		$ads = self::getSiteAds();
		$tmpl = new EasyTemplate( $wgAdSS_templatesDir );

		$adsRendered = array();
		$minExpire = 60*60 + time();
		foreach( $ads as $ad ) {
			$adsRendered[] = array(
					'id'   => $ad->id,
					'html' => $ad->render( $tmpl ),
					);
			if( $minExpire > $ad->expires ) {
				$minExpire = $ad->expires;
			}
		}

		// fill slots with empty ads up to min-slots
		$adsCount = count( $adsRendered );
		$sitePricing = AdSS_Util::getSitePricing();
		if( $adsCount < $sitePricing['min-slots'] ) {
			for( $i = $adsCount; $i < $sitePricing['min-slots']; $i++ ) {
				$adsRendered[] = array( 'id' => 0, 'html' => '' );
			}
		}
		
		$response->addText( Wikia::json_encode( $adsRendered ) );
		$response->setCacheDuration( $minExpire - time() );

		return $response;
	}

	static function getSiteAds() {
		global $wgAdSS_DBname, $wgCityId, $wgMemc, $wgSquidMaxage;

		$memcKey = AdSS_Util::memcKey();
		$ads = $wgMemc->get( $memcKey );
		if( $ads === null || $ads === false ) {
			$minExpire = 60*60 + time();
			$ads = array();
			$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
			$res = $dbr->select( 'ads', '*', array(
						'ad_wiki_id' => $wgCityId,
						'ad_type' => 't',
						'ad_page_id' => 0,
						'ad_closed' => null,
						'ad_expires > NOW()'
						), __METHOD__ );
			foreach( $res as $row ) {
				$ad = AdSS_AdFactory::createFromRow( $row );
				if( $minExpire > $ad->expires ) {
					$minExpire = $ad->expires;
				}
				for( $i=1; $i<=$ad->weight; $i++ ) {
					$ads[] = $ad;
				}
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

		$memcKey = AdSS_Util::memcKey( $title->getArticleID() );
		$ads = $wgMemc->get( $memcKey );
		if( $ads === null || $ads === false ) {
			$minExpire = 60*60 + time();
			$ads = array();
			$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
			$res = $dbr->select( 'ads', '*', array(
						'ad_wiki_id' => $wgCityId,
						'ad_type' => 't',
						'ad_page_id' => $title->getArticleID(),
						'ad_closed' => null,
						'ad_expires > NOW()'
						), __METHOD__ );
			foreach( $res as $row ) {
				$ad = AdSS_AdFactory::createFromRow( $row );
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
			$text = wfMsgWikiHtml( 'adss-ad-header' );
			$text .= Xml::openElement( 'ul', array( 'class' => 'adss' ) );
			$text .= Xml::closeElement( 'ul' );
		}
		return true;
	}

	static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgTitle, $wgAdSS_templatesDir;
		if( self::canShowAds( $wgTitle ) ) {
			wfLoadExtensionMessages( 'AdSS' );
			$ads = self::getPageAds( $wgTitle );
			$tmpl = new EasyTemplate( $wgAdSS_templatesDir );
			
			$selfAd = new AdSS_TextAd();
			$selfAd->url = str_replace( 'http://', '', SpecialPage::getTitleFor( 'AdSS')->getFullURL() );
			$selfAd->text = wfMsg( 'adss-ad-default-text' );
			$selfAd->desc = wfMsg( 'adss-ad-default-desc' );

			$vars['wgAdSS_pageAds'] = array();
			foreach( $ads as $ad ) {
				$vars['wgAdSS_pageAds'][] = $ad->render( $tmpl );
			}
			$vars['wgAdSS_selfAd'] = $selfAd->render( $tmpl );
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
		if( empty($_GET['showads']) && is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ) {
			return false;
		} else {
			return  isset( $title ) && is_object( $title ) &&
				$title->exists() &&
				$title->getNamespace() == NS_MAIN &&
				!$title->equals( Title::newMainPage() );
		}
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
