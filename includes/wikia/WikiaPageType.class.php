<?php

/**
 * Utility class to check types of pages
 */
class WikiaPageType {
	public static function getPageType() {
		if (self::isMainPage()) {
			$type = 'home';
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

	public static function isMainPage() {
		$wgTitle = F::app()->wg->Title;

		$isMainPage = (
			is_object($wgTitle)
			&& $wgTitle->getArticleId() == Title::newMainPage()->getArticleId()
			&& $wgTitle->getArticleId() != 0 # caused problems on central due to NS_SPECIAL main page
			&& !self::isActionPage()
		);

		return $isMainPage;
	}

	public static function isSearch() {
		$wgTitle = F::app()->wg->Title;

		$searchPageNames = array('Search', 'WikiaSearch');

		return !empty($wgTitle) && -1 == $wgTitle->getNamespace()
			&& in_array(array_shift(SpecialPageFactory::resolveAlias($wgTitle->getDBkey())), $searchPageNames);
	}

	public static function isForum() {
		$wgEnableForumExt = F::app()->wg->EnableForumExt;
		$wgIsForum = F::app()->wg->IsForum;

		return (!empty($wgEnableForumExt) && !empty($wgIsForum));
	}

	public static function isExtra() {
		$wgTitle = F::app()->wg->Title;
		$wgExtraNamespaces = F::app()->wg->ExtraNamespaces;

		return array_key_exists($wgTitle->getNamespace(), $wgExtraNamespaces);
	}

	public static function isContentPage() {
		$wgTitle = F::app()->wg->Title;

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
		return (is_object($wgTitle) && in_array($wgTitle->getNamespace(), $contentNamespaces));
	}

	/**
	 * Check if page is action page, i.e. non-view.
	 * Diff is considered action page as well
	 *
	 * @return bool
	 */
	public static function isActionPage() {
		return (
			F::app()->wg->Request->getVal('action', 'view') !== 'view'
			|| F::app()->wg->Request->getVal('diff')
		);
	}

	public static function isWikiaHub() {
		// TODO: make this better!
		global $wgEnableWikiaHubsExt, $wgWikiaHubsPages, $wgTitle;

		$titleParts = explode('/', $wgTitle->getDBkey());
		$hub = false;
		if(!empty($wgEnableWikiaHubsExt)) {
			foreach($wgWikiaHubsPages as $hubGroup) {
				if(in_array($titleParts[0], $hubGroup)) {
					$hub = true;
				}
			}
		}

		return $hub;
	}
}
