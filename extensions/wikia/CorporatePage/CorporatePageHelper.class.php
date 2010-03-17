<?php

/*
 * Author: Tomek Odrobny
 * Helper function for extension
 */

class CorporatePageHelper{
	/*
	* Author: Tomek Odrobny
	* Hook for clear parsed message cache
	*/
	static function clearMessageCache(&$article){
		global $wgTTCache;
		
		$title = strtolower($article->getTitle()); 
		if (! (strpos($title, "mediawiki:") === 0 )){
			return true;
		}
		
		$CorporatePageMessageList = 
			array(	'corporatepage-footer-middlecolumn',
					'corporatepage-footer-bottom',
					'corporatepage-footer-rightcolumn',
					'corporatepage-footer-bottom',
					'corporatepage-footer-leftcolumn',
					'corporatepage-slider',
					'corporatepage-sidebar',
					'corporatepage-wikia-whats-up',
					'corporatepage-test-msg' );
	

		wfRunHooks( 'CorporateBeforeMsgCacheClear', array( &$CorporatePageMessageList ) ); 

		foreach ($CorporatePageMessageList as $value) {
			$value = wfMemcKey( "hp_msg_parser", strtolower(  $value  ) ) ;
			$wgTTCache->set( $value, "-1" );
		}
		return true;
	}
	

	static function jsVars($vars){
		global $wgUser;
		wfLoadExtensionMessages( 'CorporatePage' );
		if ($wgUser->isAllowed( 'corporatepagemanager' )){
			$vars['corporatepage_hide_confirm'] = wfMsg('corporatepage-hide-confirm');
			$vars['corporatepage_hide_error'] = wfMsg('corporatepage-hide-error');
			$vars['corporatepage_hide_success'] = wfMsg('corporatepage-hide-success');
		}
		return true;
	}

	static function blockArticle(){
		global $wgUser,$wgExternalDatawareDB,$wgRequest;

		$response = new AjaxResponse();
		if ((!$wgUser->isAllowed( 'corporatepagemanager' )) || (!$wgRequest->wasPosted())) {
			$response->addText(json_encode( array(
					'status' => "ERROR1" )));
			return $response;
		}
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
		$dbw->begin();

		$article = $wgRequest->getVal('wiki').":".$wgRequest->getVal('name');
		if (!WikiaGlobalStats::excludeArticle($article)){
			$response->addText(json_encode( array(
					'status' => "ERROR2" )));
			return $response;
		}

		$response->addText(json_encode( array(
				'status' => "OK" )));
		$dbw->commit();
		return $response;
	}
	
		

	/*
	 * parseMsg
	 *
	 * message parsers for menu and etc.
	 *
	 * @author Tomek
	 */
	
	static public function parseMsg($msg,$isFavicon = false){
		global $wgTTCache, $wgArticlePath;
		$mcKey = wfMemcKey( "hp_msg_parser", strtolower( $msg ) );
		$out = $wgTTCache->get( $mcKey, -1 );
		if ( is_array($out) ){
			return $out;
		}
        wfProfileIn( __METHOD__ );     
		$message = wfMsgForContent($msg);
		$lines = explode("\n",$message);
		$out = array();
		foreach($lines as $v){
			if (preg_match("/^([\*]+)([^|]+)\|(((.*)\|(.*))|(.*))$/",trim($v),$matches)){
				$param = "";
				
				if (!empty($matches[5])){
					$param = $matches[6];
					$title = trim($matches[5]);
				} else {
					$title = trim($matches[3]);
				}
					
				if (strlen($matches[1]) == 1){
					$matches[2] = trim($matches[2]);
					if (preg_match('/^(?:' . wfUrlProtocols() . ')/', $matches[2])) {
						$href = $matches[2];
					} else {
						$href = str_replace('$1', $matches[2], $wgArticlePath);
					}
					$out[] = array("title" => $title, 'href' => $href, 'sub' => array());
				}
			
				if (strlen($matches[1]) == 2){
					if (count($out) > 0){
						if ($isFavicon){
							$id = (int) WikiFactory::UrlToID(trim($matches[2]));
							$favicon = "";
							if ($id > 0){
								$favicon = WikiFactory::getVarValueByName( "wgFavicon", $id );
							}
						}
						$out[count($out) - 1]['sub'][] = array("param" => $param, "favicon" => $favicon, "title" => $title, 'href' => trim($matches[2]));
					}
				}
			}
		}
		if (count($out) >0){
			$out[0]['isfirst'] = true;
			$out[count($out)-1]['islast'] = true;
		}
		$wgTTCache->set( $mcKey, $out, 60*60*12);
        wfProfileOut( __METHOD__ );     
		return $out;
	}
	
	/*
	 *
	 * message parsers for menu and etc., with images  
	 *
	 * @author Tomek
	 */
	
	static public function parseMsgImg($msg,$descThumb = false){
		global $wgTTCache;
		$mcKey = wfMemcKey( "hp_msg_parser", strtolower( $msg ) );
		$out = $wgTTCache->get( $mcKey, -1 );
		if ( is_array( $out ) ){
			return $out;
		}
        	wfProfileIn( __METHOD__ );        
		$message = wfMsgForContent($msg);
		$lines = explode("\n",$message);
		$out = array();
		foreach($lines as $v){
			if ($descThumb){
				$str = "/^([\*]+)([^|]+)\|([^|]+)\|([^|]+)\|([^|]+)\|(.*)$/";
			} else {
				$str = "/^([\*]+)([^|]+)\|([^|]+)\|(((.*)\|(.*))|(.*))$/";
			}
				
			if (preg_match($str,trim($v),$matches)){
				if (strlen($matches[1]) == 1){
					if ($descThumb){
						$imageName = self::getImageName($matches[5]);
						$thumbName = self::getImageName($matches[6]);
						$out[] = array("desc" => $matches[4],"imagethumb" => $thumbName,"imagename" => $imageName, "title" => trim($matches[3]), 'href' => trim($matches[2]),'sub' => array());
					} else {
						$param = "";
						if (!empty($matches[7])){
							$param = $matches[7];
							$rowImageName = $matches[6];
						} else{
							$rowImageName = $matches[4];
						}
						$imageName = self::getImageName($rowImageName);
						$out[] = array("param" => $param,"imagename" => $imageName, "title" => trim($matches[3]), 'href' => trim($matches[2]),'sub' => array());
					}
				}
			}
		}
		$wgTTCache->set( $mcKey, $out, 60*60*12);
        	wfProfileOut( __METHOD__ );         
		return $out;
	}

	/*
	 * getImageName
	 *
	 * find media wiki image path 
	 *
	 * @author Tomek
	 */
	
	private static function getImageName($name){
		global $wgStylePath;
		$image = Title::newFromText($name);
		$image = wfFindFile($image);
		$imageName = $wgStylePath."/common/dot.gif";
		if (($image) && ($image->exists())){
			$imageName = $image->getViewURL();
		}
		return $imageName;
	}
	
	/*
	 * ArticleFromTitle
	 *
	 * force page reload 
	 *
	 * @author Tomek
	 */	
	
	public static function forcePageReload($modifiedTimes){
		global $wgTitle; 
		$mainPage =  Title::newMainPage();
		
		if ($mainPage->getText() == $wgTitle->getText()){
			$modifiedTimes['page'] = wfTimestamp( TS_MW );	
		}
		
		return true;	
	}

	/*
	 * ArticleFromTitle
	 *
	 * hook handler for redirecting pages from old central to new community wiki
	 *
	 * @author Marooned
	 */
	static function ArticleFromTitle(&$title, &$article) {
		global $wgRequest,$wgTitle;
		//do not redirect for action different than view (allow creating, deleting, etc)
		if ($wgRequest->getVal('action', 'view') != 'view') {
			return true;
		}
		wfProfileIn(__METHOD__);

		
		switch ($title->getNamespace()) {
			case NS_USER:
			case NS_USER_TALK:
			case NS_FILE:
			case NS_FILE_TALK:
			case NS_HELP:
			case NS_HELP_TALK:
			case NS_CATEGORY_TALK:
			case 110: //NS_FORUM
			case 111: //NS_FORUM_TALK
			case 150: //NS_HUB
			case 151: //NS_HUB_TALK
			case 400: //NS_VIDEO
			case 401: //NS_VIDEO_TALK
			case 500: //NS_BLOG_ARTICLE
			case 501: //NS_BLOG_ARTICLE_TALK
			case 502: //NS_BLOG_LISTING
			case 503: //NS_BLOG_LISTING_TALK
				if (!$title->exists()) {
					$redirect = 'http://community.wikia.com/wiki/' . $title->prefix($title->getPartialURL());
				}
				break;

			case NS_PROJECT:
			case NS_PROJECT_TALK:
				if (!$title->exists()) {
					//"Project" namespace hardcoded because MW will rename it to name of redirecting page - not the destination wiki
					$redirect = 'http://community.wikia.com/wiki/Project:' . $title->getPartialURL();
				}
				break;

			case NS_CATEGORY:
			case NS_MAIN:
				if (!$title->exists()) {
					$redirect = 'http://www.wikia.com/wiki/Special:Search?search=' . wfUrlencode($title->getText());
				}
				break;

			case NS_TALK:
				$t = $title->getSubjectPage();
				if ($t->exists()) {
					$redirect = 'http://www.wikia.com/wiki/' . $t->getPartialURL();
				} else {
					$redirect = 'http://www.wikia.com/wiki/Special:Search?search=' . wfUrlencode($t->getText());
				}
				break;
		}

		if( !wfRunHooks( 'CorporateBeforeRedirect', array( &$title ) ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}
		
		if (!empty($redirect)) {
			header("Location: $redirect");
			wfProfileOut(__METHOD__);
			exit;
		}
		wfProfileOut(__METHOD__);
		return true;
	}
}
