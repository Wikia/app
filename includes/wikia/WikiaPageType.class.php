<?php

/**
 * Utility class to check types of currently rendered page
 */
class WikiaPageType {
	/**
	 * Get type of page as string
	 *
	 * @return string one of corporate, home, search, forum, article or extra
	 */
	public static function getPageType() {
		if (self::isMainPage()) {
			$type = 'home';
		} elseif (self::isFilePage()) {
			$type = 'file';
		} elseif (self::isSearch()) {
			$type = 'search';
		} elseif (self::isForum()) {
			$type = 'forum';
		} elseif (self::isExtra()) {
			$type = 'extra';
		} else {
			$type = 'article';
		}

		return $type;
	}

	/**
	 * Check if current page is main page
	 *
	 * @return bool
	 */
	public static function isMainPage() {
		$title = F::app()->wg->Title;

		$isMainPage = (
			is_object($title)
			&& $title->isMainPage()
			&& $title->getArticleId() != 0 # caused problems on central due to NS_SPECIAL main page
			&& !self::isActionPage()
		);

		return $isMainPage;
	}

	/**
	 * Check if current page is article
	 *
	 * @return bool
	 */
	public static function isArticlePage() {
		$title = F::app()->wg->Title;

		$isArticlePage = (
			is_object($title)
			&& $title->getArticleId() != 0
			&& $title->getNamespace() == 0
			&& !self::isMainPage()
		);

		return $isArticlePage;
	}

	/**
	 * Check if current page is search page
	 *
	 * @return bool
	 */
	public static function isSearch() {
		$title = F::app()->wg->Title;

		$searchPageNames = array('Search', 'WikiaSearch');
		$pageNames = SpecialPageFactory::resolveAlias($title->getDBkey());

		return -1 === $title->getNamespace() && in_array(array_shift($pageNames), $searchPageNames);
	}

	/**
	 * Check if current page is file page
	 *
	 * @return bool
	 */
	public static function isFilePage() {
		global $wgTitle;

		return !empty($wgTitle) && NS_FILE === $wgTitle->getNamespace();
	}

	/**
	 * Check if current page is forum page (Special:Forum or forum board or forum thread)
	 *
	 * @return bool
	 */
	public static function isForum() {
		$wg = F::app()->wg;

		return (
			(defined('NS_FORUM') && $wg->Title && $wg->Title->getNamespace() === NS_FORUM) // old forum
			|| ($wg->EnableForumExt && ForumHelper::isForum())                             // new forum
		);
	}

	/**
	 * Check if current page is extra page -- i.e. in one of namespaces defined in wgExtraNamespaces
	 *
	 * @return bool
	 */
	public static function isExtra() {
		$title = F::app()->wg->Title;
		$extraNamespaces = F::app()->wg->ExtraNamespaces;

		return array_key_exists($title->getNamespace(), $extraNamespaces);
	}

	/**
	 * Check if current page is content page -- i.e. in one of namespaces defined in wgContentNamespaces
	 *
	 * @return bool
	 */
	public static function isContentPage() {
		$title = F::app()->wg->Title;

		$contentNamespaces = array_merge(
			F::app()->wg->ContentNamespaces,
			array(NS_MAIN, NS_IMAGE, NS_CATEGORY)
		);

		// not a content page if we're on action page
		if (self::isActionPage()) {
			return false;
		}

		// actual content namespace checked along with hardcoded override (main, image & category)
		// note this is NOT used in isMainPage() since that is to ignore content namespaces
		return (is_object($title) && in_array($title->getNamespace(), $contentNamespaces));
	}

	/**
	 * Check if page is action page, i.e. non-view.
	 * Diff is considered action page as well
	 *
	 * @return bool
	 */
	public static function isActionPage() {
		$request = F::app()->wg->Request;

		return (
			$request->getVal('action', 'view') !== 'view'
			|| $request->getVal('diff') !== null
		);
	}

	/**
	 * Check if page is Wikia hub page, for example http://www.wikia.com/Video_games
	 *
	 * @return bool
	 */
	public static function isWikiaHub() {
		global $wgEnableWikiaHubsV3Ext;

		return !empty( $wgEnableWikiaHubsV3Ext );
	}

	/**
	 * Check if current page is Wikia hub main page ( for hubs v3 )
	 *
	 * @return bool
	 */
	public static function isWikiaHubMain() {
		global $wgTitle;
		$mainPageName = trim( str_replace( '_', ' ', wfMessage( 'mainpage' )->inContentLanguage()->text() ) );
		$isMainPage = ( strcasecmp( $mainPageName, $wgTitle->getText() ) === 0 ) && $wgTitle->getNamespace() === NS_MAIN;

		return ( self::isWikiaHub() && $isMainPage );
	}

	/**
	 * Check if current page is home page
	 *
	 * @return bool
	 */
	public static function isWikiaHomePage() {
		global $wgEnableWikiaHomePageExt;

		return !empty( $wgEnableWikiaHomePageExt );
	}

	/**
	 * Check if current page is corporate page
	 *
	 * @return bool
	 */
	public static function isCorporatePage() {
		return self::isWikiaHub() || self::isWikiaHomePage();
	}
}
