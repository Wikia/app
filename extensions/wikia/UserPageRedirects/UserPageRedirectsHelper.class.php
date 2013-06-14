<?php

/*
 * Author: Tomek Odrobny
 * Author: Damian Jóźwiak
 * Helper function for extension
 */

class UserPageRedirectsHelper {

	/**
	 * ArticleFromTitle
	 *
	 * hook handler for redirecting pages from old central to new community wiki
	 *
	 * @author Marooned
	 */
	static function ArticleFromTitle(Title &$title, &$article) {
		global $wgRequest, $wgCorporatePageRedirectWiki;
		//do not redirect for action different than view (allow creating, deleting, etc)
		if ($wgRequest->getVal('action', 'view') != 'view') {
			return true;
		}
		wfProfileIn(__METHOD__);


		switch ($title->getNamespace()) {
			case NS_USER:
			case NS_USER_TALK:
			case NS_FILE_TALK:
			case NS_HELP:
			case NS_HELP_TALK:
			case NS_CATEGORY_TALK:
			case NS_FORUM:
			case NS_FORUM_TALK:
			case 150: //NS_HUB
			case 151: //NS_HUB_TALK
			case 400: //NS_VIDEO
			case 401: //NS_VIDEO_TALK
			case 500: //NS_BLOG_ARTICLE
			case 501: //NS_BLOG_ARTICLE_TALK
			case 502: //NS_BLOG_LISTING
			case 503: //NS_BLOG_LISTING_TALK
			case 1200: // NS_WALL
				if (!$title->exists() && !empty( $wgCorporatePageRedirectWiki )) {
					$redirect = $wgCorporatePageRedirectWiki . self::getPrefixedText($title->getPartialURL(),array($title->getInterwiki(),$title->getNsText()));
				}
				break;
			case NS_FILE:
				$file = wfFindFile($title);
				if (empty($file) && !empty( $wgCorporatePageRedirectWiki )) {
					$redirect = $wgCorporatePageRedirectWiki . self::getPrefixedText($title->getPartialURL(),array($title->getInterwiki(),$title->getNsText()));
				}
				break;
			case NS_PROJECT:
			case NS_PROJECT_TALK:
				if (!$title->exists()) {
					//"Project" namespace hardcoded because MW will rename it to name of redirecting page - not the destination wiki
					$redirect = 'http://community.wikia.com/wiki/Project:' . $title->getPartialURL();
				}
				break;

			case NS_TALK:
				$t = $title->getSubjectPage();
				if ($t->exists()) {
					$redirect = 'http://www.wikia.com/' . $t->getPartialURL();
				}
				break;
		}

		if( !wfRunHooks( 'UserPageRedirectsBeforeRedirect', array( &$title ) ) ) {
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

	public static function getPrefixedText($text,$prefixes = array()) {
		if(!empty($prefixes)) {
		    return implode(':', array_merge($prefixes,array($text)));
		} else {
			return $text;
		}
	}
}
