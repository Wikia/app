<?php

use Wikia\Util\Assert;

/**
 * Utility class to check types of currently rendered page
 */
class WikiaPageType {

	/**
	 * Get the current $wgTitle
	 *
	 * This method additionally resolves redirects
	 *
	 * @return Title|null title instance
	 */
	private static function getTitle() {
		$title = F::app()->wg->Title;

		// follow redirects
		if ( $title instanceof Title && $title->isRedirect() ) {
			$page = WikiPage::factory( $title );
			$tmpTitle = $page->getRedirectTarget();

			// TODO check why $title->isRedirect() is true and there is no redirectTarget
			if ( $tmpTitle instanceof Title ) {
				$title = $tmpTitle;
			}
		}

		return $title;
	}

	/**
	 * Get type of page as string
	 *
	 * @return string one of corporate, home, search, forum, article or extra
	 */
	public static function getPageType() {
		if ( self::isMainPage() ) {
			$type = 'home';
		} elseif ( self::isFilePage() ) {
			$type = 'file';
		} elseif ( self::isSearch() ) {
			$type = 'search';
		} elseif ( self::isForum() ) {
			$type = 'forum';
		} elseif ( self::isExtra() ) {
			$type = 'extra';
		} elseif ( self::isSpecial() ) {
			$type = 'special';
		} else {
			$type = 'article';
		}

		return $type;
	}

	/**
	 * Get article type (as in: games, tv series, etc)
	 * of current page
	 *
	 * @param Title $title
	 * @return string
	 */
	public static function getArticleType( $title = null ) {
		global $wgTitle;

		if ( is_null( $title ) ) {
			$title = $wgTitle;
		}

		$articleService = new ArticleService( $title );
		return $articleService->getArticleType();
	}

	/**
	 * Check if current page is main page
	 *
	 * @return bool
	 */
	public static function isMainPage() {
		$title = self::getTitle();

		$isMainPage = (
			$title instanceof Title
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
		$title = self::getTitle();

		$isArticlePage = (
			$title instanceof Title
			&& $title->getArticleId() != 0
			&& $title->getNamespace() == 0
			&& !self::isMainPage()
			&& !self::isEditPage()
		);

		return $isArticlePage;
	}

	/**
	 * Check if current page is edit, formedit, history or submit
	 *
	 * @return bool
	 */
	public static function isEditPage() {
		global $wgRequest;

		return in_array(
			$wgRequest->getVal( 'action', 'view' ),
			array( 'edit', 'formedit' , 'history' , 'submit' )
		);
	}

	/**
	 * Check if current page is search page
	 *
	 * @return bool
	 */
	public static function isSearch() {
		$title = self::getTitle();

		$searchPageNames = array( 'Search', 'WikiaSearch' );
		$pageNames = SpecialPageFactory::resolveAlias( $title->getDBkey() );

		return ( $title instanceof Title ) && $title->isSpecialPage()
		&& in_array( array_shift( $pageNames ), $searchPageNames );
	}

	/**
	 * Check if current page is file page
	 *
	 * @return bool
	 */
	public static function isFilePage() {
		$title = self::getTitle();

		return ( $title instanceof Title ) && NS_FILE === $title->getNamespace();
	}

	/**
	 * Check if current page is forum page (Special:Forum or forum board or forum thread)
	 *
	 * @return bool
	 */
	public static function isForum() {
		$title = self::getTitle();

		return (
			( defined( 'NS_FORUM' ) && $title instanceof Title && $title->getNamespace() === NS_FORUM ) // old forum
			|| ( F::app()->wg->EnableForumExt && ForumHelper::isForum() )                               // new forum
		);
	}

	/**
	 * Check if current page is a special page (Special:*)
	 *
	 * @return bool
	 */
	public static function isSpecial() {
		$title = self::getTitle();

		return $title->isSpecialPage();
	}

	/**
	 * Check if current page is extra page -- i.e. in one of namespaces defined in wgExtraNamespaces
	 *
	 * @return bool
	 */
	public static function isExtra() {
		$title = self::getTitle();

		return $title instanceof Title && array_key_exists( $title->getNamespace(), F::app()->wg->ExtraNamespaces );
	}

	/**
	 * Check if current page is content page -- i.e. in one of namespaces defined in wgContentNamespaces
	 *
	 * @return bool
	 */
	public static function isContentPage() {
		$title = self::getTitle();

		$contentNamespaces = array_merge(
			F::app()->wg->ContentNamespaces,
			array( NS_MAIN, NS_IMAGE, NS_CATEGORY )
		);

		// not a content page if we're on action page
		if ( self::isActionPage() ) {
			return false;
		}

		// actual content namespace checked along with hardcoded override (main, image & category)
		// note this is NOT used in isMainPage() since that is to ignore content namespaces
		return ( $title instanceof Title && in_array( $title->getNamespace(), $contentNamespaces ) );
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
			$request->getVal( 'action', 'view' ) !== 'view'
			|| $request->getVal( 'diff' ) !== null
		);
	}

	/**
	 * Check if page is Wikia hub page, for example http://www.wikia.com/Video_games
	 *
	 * @param int|null $wikiId
	 * @return bool
	 */
	public static function isWikiaHub( $wikiId = null ) {
		global $wgCityId;

		return WikiFactory::getVarValueByName( 'wgEnableWikiaHubsV3Ext', $wikiId ?? $wgCityId );
	}

	/**
	 * Check if current page is Wikia hub main page ( for hubs v3 )
	 *
	 * @param Title|null $title optional title to perform a check for (instead of wgTitle as it's not always set - see SUS-11)
	 * @return bool
	 * @throws \Wikia\Util\AssertionException
	 */
	public static function isWikiaHubMain( $title = null ) {
		$title = $title ?: self::getTitle();

		Assert::true( $title instanceof Title, __METHOD__ ); // SUS-11

		$mainPageName = self::getMainPageName();
		$isMainPage = ( strcasecmp( $mainPageName, $title->getText() ) === 0 ) && $title->getNamespace() === NS_MAIN;

		return ( self::isWikiaHub() && $isMainPage );
	}

	/**
	 * @return string
	 */
	public static function getMainPageName() {
		return trim( str_replace( '_', ' ', wfMessage( 'mainpage' )->inContentLanguage()->text() ) );
	}

	/**
	 * Check if current page is home page
	 *
	 * @param int|null $wikiId
	 * @return bool
	 */
	public static function isWikiaHomePage( $wikiId = null ) {
		global $wgCityId;

		return WikiFactory::getVarValueByName( 'wgEnableWikiaHomePageExt', $wikiId ?? $wgCityId );
	}

	/**
	 * Check if current page is corporate page
	 *
	 * @param int|null $wikiId
	 * @return bool
	 */
	public static function isCorporatePage( $wikiId = null ) {
		return self::isWikiaHub( $wikiId ) || self::isWikiaHomePage( $wikiId );
	}
}
