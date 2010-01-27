<?php

/*
 * Author: Tomek Odrobny
 * Helper function for extension
 */

class CorporatePageHelper{
	/*
	* Author: Tomek Odrobny
	* Hook for clear parsed message cache
	*
	 	static function clearMessageCache($title, $text){
		global $CorporatePageMessageList,$wgMemc;
		$title = strtolower($title);
		if (in_array($title,$CorporatePageMessageList)){
			$wgMemc->delete(wfMemcKey( "hp_msg_parser", $title ));
			$pageList = $wgMemc->get(wfMemcKey( "hp_page_list"),null);
			if ($pageList != null){
				$pageList = array_keys($pageList);
				foreach ($pageList as $value){
					$cachedTitle = Title::newFromURL($value);
					$cachedTitle->purgeSquid();
				}
				$pageList = $wgMemc->delete(wfMemcKey( "hp_page_list"));
			}
		}
		return true;
	}
	*/

	static function jsVars($vars){
		global $wgUser;
		if ($wgUser->isAllowed( 'corporatepagemanager' )){
			$vars['home2_hide_confirm'] = wfMsg('home2-hide-confirm');
			$vars['home2_hide_error'] = wfMsg('home2_hide_error');
			$vars['home2_hide_success'] = wfMsg('home2_hide_success');
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
	 * ArticleFromTitle
	 *
	 * hook handler for redirecting pages from old central to new community wiki
	 *
	 * @author Marooned
	 */
	static function ArticleFromTitle(&$title, &$article) {
		switch ($title->getNamespace()) {
			case NS_HELP:
			case NS_USER_TALK:
			case 150: //NS_HUB
			case 500: //NS_BLOG_ARTICLE
			case 501: //NS_BLOG_ARTICLE_TALK
			case 502: //NS_BLOG_LISTING
			case 503: //NS_BLOG_LISTING_TALK
				$redirect = 'http://community.wikia.com/wiki/' . $title->prefix($title->getPartialURL());
				break;

			case NS_PROJECT:
				//"Project" namespace hardcoded because MW will rename it to name of redirecting page - not the destination wiki
				$redirect = 'http://community.wikia.com/wiki/Project:' . $title->getPartialURL();
				break;

			case NS_CATEGORY:
			case NS_MAIN:
				if (!$title->exists()) {
					$redirect = 'http://www.wikia.com/wiki/Special:Search?search=' . wfUrlencode($title->getText());
				}
				break;
		}
		if (!empty($redirect)) {
			header("Location: $redirect");
			exit;
		}
		return true;
	}
}
