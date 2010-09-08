<?php

/*
 * Author: Tomek Odrobny, Bartek Lapinski
 * Helper function for extension
 */

class AutoHubsPagesHelper{

	/*
	* Author: Tomek Odrobny
	* check if it is title for hubs pages
	*/
	static function isHubsPage(Title &$title){
		global $wgHubsPages, $wgContLanguageCode;
		wfProfileIn( __METHOD__ ); 

		if( empty($wgHubsPages[$wgContLanguageCode]) ) {
			return false;
		}

		foreach( $wgHubsPages[$wgContLanguageCode] as $key => $value ){
			if(is_array($key)) {
				$key = $key['name'];
			}

			if (strtolower($title->getUserCaseDBKey()) == strtolower($key)){
				wfProfileOut( __METHOD__ ); 
				return true;
			}
		}
		wfProfileOut( __METHOD__ ); 
		return false;
	}

	/*
	* Author: Bartek Lapinski
	* set the value of a variable for that tag when an admin clicks
	* on the 'hide' link for the feed
	* an ajax function
	*/
	static function setHubsFeedsVariable() {
		global $wgRequest, $wgCityId, $wgMemc, $wgUser;
		wfProfileIn( __METHOD__ ); 

		if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) {
			$result['response'] = 'error';										
		} else {
			$result = array( 'response'	=>	'ok' );			
			$tagname = $wgRequest->getVal( 'tag' );
			$feedname = strtolower( $wgRequest->getVal( 'feed' ) );
			$key = wfMemcKey( 'autohubs', $tagname, 'feeds_displayed' );

			$oldtags = self::getHubsFeedsVariable( $tagname );

			$oldtags[$tagname][$feedname] = !$oldtags[$tagname][$feedname] ;
			$result['disabled'] = $oldtags[$tagname][$feedname];

			if( !WikiFactory::setVarByName( 'wgWikiaAutoHubsFeedsDisplayed', $wgCityId, $oldtags ) ) {
				$result['response'] = 'error';
			} else {
				$wgMemc->delete( $key );
			}			
		}
		$json = Wikia::json_encode($result);
		$response = new AjaxResponse( $json );
		$response->setCacheDuration( 0 );
		$response->setContentType('text/plain; charset=utf-8');

		wfProfileOut( __METHOD__ );
		return $response;
	}

	/*
	* Author: Bartek Lapinski
	* returns a default array for feed visibility
	*/
	static function getDefaultHubsFeeds() {
		return array(
				'topwikis'      =>      true,
				'topblogs'      =>      true,
				'hotspots'      =>      true,
				'topeditors'    =>      true
			    );
	}

	/*
	* Author: Bartek Lapinski
	* get the visibility of feeds for a given tag
	*/
	static function getHubsFeedsVariable( $tagname ) {
		global $wgMemc, $wgCityId;
		wfProfileIn( __METHOD__ ); 
		$key = wfMemcKey( 'autohubs', $tagname, 'feeds_displayed' );
		$data = $wgMemc->get( $key );
		if( !$data ) {
			$feeds = unserialize( WikiFactory::getVarByName( 'wgWikiaAutoHubsFeedsDisplayed', $wgCityId )->cv_value );
			if( !empty( $feeds[$tagname] ) && is_array( $feeds[$tagname] )) {
				$tag = $feeds;				
			} else {
				$tag[$tagname] = self::getDefaultHubsFeeds();
			}		
			$wgMemc->set( $key, $tag );
		} else {
			$tag = $data;
		}

		wfProfileOut( __METHOD__ ); 
		return $tag;
	}
	
	/*
	* Author: Tomek Odrobny
	* hook add to CorporatePage redirect
	*/	
	
	static function hideFeed() {
		global $wgUser, $wgRequest, $wgLang;
		$response = new AjaxResponse();
		$result = array();
		if( !$wgUser->isAllowed( 'corporatepagemanager' ) ) {
			$result['response'] = 'error';		
			$response->addText(json_encode( $result ));
			return 	$response ;						
		}
		
		$tag_id = (int) $wgRequest->getVal('tag_id', 0); 
		$city_id = (int) $wgRequest->getVal('city_id', 0); 
		$page_id = (int) $wgRequest->getVal('page_id', 0);
		$dir = $wgRequest->getVal('dir', 'add');  
		$ws = new WikiaStatsAutoHubsConsumerDB();		
		$result = array();
		if ($dir == 'add') {
			if ( $wgRequest->getVal('type') == 'article') {
				if ($ws->addExludeArticle($tag_id, $city_id, $page_id, $wgLang->getCode())) {
					$result['response'] = 'ok';	
				}
			}
		
			if ( $wgRequest->getVal('type') == 'blog') {
				if ($ws->addExludeBlog($tag_id, $city_id, $page_id, $wgLang->getCode())) {
					$result['response'] = 'ok';	
				}
			}
		
			if ( $wgRequest->getVal('type') == 'city') {
				if ($ws->addExludeWiki($tag_id, $city_id, $wgLang->getCode())) {
					$result['response'] = 'ok';		
				}
			}
		} else {
			$result['response'] = 'ok';	
			if ( $wgRequest->getVal('type') == 'article') {
				$ws->removeExludeArticle($tag_id, $city_id, $page_id, $wgLang->getCode());
			}
		
			if ( $wgRequest->getVal('type') == 'blog') {
				$ws->removeExludeBlog($tag_id, $city_id, $page_id, $wgLang->getCode());
			}
		
			if ( $wgRequest->getVal('type') == 'city') {
				$ws->removeExludeWiki($tag_id, $city_id, $wgLang->getCode());
			}
		}	

		$result['response'] = 'ishide';	
		$response->addText(json_encode( $result ));
		
		return 	$response ;	
	}
	
	/*
	* Author: Tomek Odrobny
	* hook add to CorporatePage redirect
	*/	
	static function beforeRedirect(&$title){
		return !self::isHubsPage($title);
	}
	
	/*
	* Author: Tomek Odrobny
	* get hub tag id from title
	*/
	
	static function getHubIdFromTitle($title){
		global $wgHubsPages, $wgContLanguageCode;

		if( empty($wgHubsPages[$wgContLanguageCode]) ) {
			return false;
		}

		if (self::isHubsPage($title)){
			if(is_array($wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())])){
				return WikiFactoryTags::idFromName($wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())]['name']);
			}
			return WikiFactoryTags::idFromName($wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())]);
		} else {
			return false;
		}
	}

	/*
	* Author: Tomek Odrobny
	* get lang for hub 
	*/
	
	static function getLangForHub(Title &$title){
		global $wgHubsPages, $wgContLanguageCode;
		wfProfileIn( __METHOD__ );

		if( is_array($wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())]) ) {
			wfProfileOut( __METHOD__ );
			return $wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())]['langcode'];
		}

		return $wgContLanguageCode;

	}
	
	/*
	* Author: Bartek Lapinskl
	* get normalised hub tag name from title
	*/

	static function getHubNameFromTitle($title){
		global $wgHubsPages, $wgContLanguageCode;

		if (self::isHubsPage($title)){
			if(is_array($wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())])){
				return $wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())]['name'];
			}
			return $wgHubsPages[$wgContLanguageCode][strtolower($title->getUserCaseDBKey())];
		} else {
			return false;
		}
	}

	/*
	* Author: Tomasz Odrobny
	* add slider msg to list of cached msg
	*/
	
	static function beforeMsgCacheClear(&$list) {
		global $wgHubsPages;
		$values = array_values( $wgHubsPages );
		
		foreach ( $values as $key =>  $value) {
			if(is_array($value)) {
				$values[ $key ] = 'Hub-' . $value['name'] . $name['lengcode'] .'-slider';
			} else {
				$values[ $key ] = 'Hub-' . $value . '-slider';
			}
		}
		$list = array_merge( $list, $values ); 			
		return true;
	}

	// move to AdEngine, use hooks
	static function showAds() {
		global $wgAdslot_AutoHubsPages, $wgTitle;
		$title = $wgTitle->getUserCaseDBKey();

		if (empty($wgAdslot_AutoHubsPages)) return true;
		if (!isset($wgAdslot_AutoHubsPages[$title])) return true;
		if ($wgAdslot_AutoHubsPages[$title] !== false) return true;

		return false;
	}
}
