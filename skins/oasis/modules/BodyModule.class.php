<?php
class BodyModule extends Module {

	// global vars
	var $wgBlankImgUrl;
	var $wgSitename;
	var $wgUser;
	var $wgTitle;

	// skin vars
	var $content;

	var $afterBodyHtml;
	var $headerModuleName;
	var $headerModuleAction;
	var $headerModuleParams;
	var $leaderboardToShow;
	var $railModuleList;
	var $displayComments;

	var $isMainPage;

	private static $onEditPage;

	/**
	 * This method is called when edit form is rendered
	 */
	public static function onEditPageRender(&$editPage) {
		self::$onEditPage = true;
		return true;
	}

	/**
	 * Detect we're on edit (or diff) page
	 */
	public static function isEditPage() {
		global $wgRequest;
		return !empty(self::$onEditPage) ||
			$wgRequest->getInt('diff') /* diff pages */ ||
			in_array($wgRequest->getVal('action', 'view'), array('edit' /* view source page */, 'formedit' /* SMW edit pages */, 'history' /* history pages */));
	}

	/**
	 * Check whether current page is blog post
	 */
	public static function isBlogPost() {
		global $wgTitle;
		return defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE && $wgTitle->isSubpage();
	}

	/**
	 * Check whether current page is blog listing
	 */
	public static function isBlogListing() {
		global $wgTitle;
		return defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING;
	}

	/**
	 * Decide whether to show user pages header on current page
	 */
	public static function showUserPagesHeader() {
		wfProfileIn(__METHOD__);

		global $wgTitle;

		// perform namespace and special page check
		$ret = in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces())
				|| $wgTitle->isSpecial( 'Following' )
				|| $wgTitle->isSpecial( 'Contributions' )
				|| (defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return list of namespaces on which user pages header should be shown
	 */
	public static function getUserPagesNamespaces() {
		$namespaces = array(NS_USER, NS_USER_TALK);
		if (defined('NS_BLOG_ARTICLE')) {
			$namespaces[] = NS_BLOG_ARTICLE;
		}
		if (defined('NS_BLOG_LISTING')) {
			// FIXME: THIS IS NOT REALLY PART OF THE USER PAGES NAMESPACES
			//$namespaces[] = NS_BLOG_LISTING;
		}
		return $namespaces;
	}

	/**
	 * Get (and cache) DB key for current special page
	 * not needed any more?

	private static function getDBkey() {
		global $wgTitle;
		static $dbKey = false;

		if ($dbKey === false) {
			if ($wgTitle->getNamespace() == NS_SPECIAL) {
				$dbKey = SpecialPage::resolveAlias($wgTitle->getDBkey());
			}
		}

		return $dbKey;
	}
	 */

	public function getRailModuleList() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgUser, $wgEnableAchievementsExt, $wgContentNamespaces, $wgEnableWikiaCommentsExt, $wgExtraNamespaces;

		$railModuleList = array();

		$namespace = $wgTitle->getNamespace();
		$subjectNamespace = MWNamespace::getSubject($namespace);

		if($namespace == NS_SPECIAL) {
			if ($wgTitle->isSpecial('Search')) {
				$railModuleList = array();
			} else if ($wgTitle->isSpecial('Leaderboard')) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					1300 => array('LatestActivity', 'Index', null),
					1290 => array('LatestEarnedBadges', 'Index', null)
				);
			} else if ($wgTitle->isSpecial('WikiActivity')) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					1300 => array('HotSpots', 'Index', null),
					1290 => array('CommunityCorner', 'Index', null),
				);
			} else if ($wgTitle->isSpecial('Following') || $wgTitle->isSpecial('Contributions') ) {
				// intentional nothing here
			} else if ($wgTitle->isSpecial('ThemeDesignerPreview') ) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					1300 => array('LatestActivity', 'Index', null),
					1250 => array('LatestPhotos', 'Index', null),
					1150 => array('Spotlights', 'Index', null),
				);
			}
			else {
				// don't show any module for MW core special pages
				$railModuleList = array();

				wfProfileOut(__METHOD__);
				return;
			}
		}
		else {
			// search module appears on all pages except search results, where it is added to the body (by BodyModule)
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
			);

		}

		// Content, category and forum namespaces
		if(	in_array($subjectNamespace, array (NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM)) ||
			in_array($subjectNamespace, $wgContentNamespaces) ||
			in_array($subjectNamespace, $wgExtraNamespaces)) {
			// add any content page related rail modules here
			$railModuleList[1300] = array('LatestActivity', 'Index', null);
			$railModuleList[1250] = array('LatestPhotos', 'Index', null);
			$railModuleList[1150] = array('Spotlights', 'Index', null);
		}

		// User page namespaces
		if(in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces())) {
			$page_owner = User::newFromName($wgTitle->getText());
			if($page_owner) {
				if(!$page_owner->getOption('hidefollowedpages')) {
					$railModuleList[1200] = array('FollowedPages', 'Index', null);
				}
				if($wgEnableAchievementsExt && !$page_owner->getOption('hidepersonalachievements')) {
					$railModuleList[1350] = array('Achievements', 'Index', null);
				}
			}
		}

		if (self::isBlogPost() || self::isBlogListing()) {
			$railModuleList[1250] = array('PopularBlogPosts', 'Index', null);
			$railModuleList[1150] = array('Spotlights', 'Index', null);
		}

		// Display comments on content and blog pages
		if ( class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck() ) {
			$this->displayComments = true;
		} else {
			$this->displayComments = false;
		}

		// we don't want any modules on these namespaces including talk namespaces (even ad modules) and on edit pages and main pages
		if (in_array($subjectNamespace, array(NS_FILE, NS_VIDEO, NS_MEDIAWIKI, NS_TEMPLATE)) || BodyModule::isEditPage() || ArticleAdLogic::isMainPage()) {
			$railModuleList = array();

			wfProfileOut(__METHOD__);
			return $railModuleList;
		}

		$railModuleList[1440] = array('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BOXAD'));
		$railModuleList[1430] = array('Ad', 'Index', array('slotname' => 'INCONTENT_BOXAD_1'));

		$railModuleList[1100] = array('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_2'));
		$railModuleList[1050] = array('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_3'));

		wfProfileOut(__METHOD__);
		return $railModuleList;
	}


	public function executeIndex() {
		global $wgOut, $wgTitle, $wgSitename, $wgUser, $wgEnableBlog;

		$this->isMainPage = ArticleAdLogic::isMainPage();

		$this->bodytext = Module::get('ContentDisplay')->getData('bodytext');
		
		global $wgNoExternals, $wgRequest;
		$noExt = $wgRequest->getVal('noexternals');
		if(!empty($noExt)){
			$wgNoExternals = true;
		}
		$this->noexternals = (!empty($wgNoExternals));

		$this->railModuleList = $this->getRailModuleList();
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		wfRunHooks('GetHTMLAfterBody', array ($wgUser->getSkin(), &$this->afterBodyHtml));

		$this->headerModuleAction = 'Index';
		$this->headerModuleParams = array ('showSearchBox' => false);

		// show user pages header on this page?
		if (self::showUserPagesHeader()) {
			$this->headerModuleName = 'UserPagesHeader';
			// is this page a blog post?
			if (self::isBlogPost()) {
				$this->headerModuleAction = 'BlogPost';
			}
			// is this page a blog listing?
			else if (self::isBlogListing()) {
				$this->headerModuleAction = 'BlogListing';
			}
		} else {
			$this->headerModuleName = 'PageHeader';
			if (self::isEditPage()) {
				$this->headerModuleAction = 'EditPage';
			}
		}

		// use one column layout for pages with no right rail modules
		if (count($this->railModuleList ) == 0) {
			OasisModule::addBodyClass('oasis-one-column');
			$this->headerModuleParams = array ('showSearchBox' => true);
		}

		// if we are on a special search page, pull in the css file and don't render a header
		if($wgTitle && $wgTitle->isSpecial( 'Search' )) {
			$wgOut->addStyle(wfGetSassUrl("skins/oasis/css/modules/SpecialSearch.scss"));
			$this->headerModuleName = null;
			$this->bodytext = wfRenderModule('Search') . $this->bodytext;
		}

		// load CSS for Special:Preferences
		if (!empty($wgTitle) && $wgTitle->isSpecial('Preferences')) {
			$wgOut->addStyle(wfGetSassUrl('skins/oasis/css/modules/SpecialPreferences.scss'));
		}

		// load CSS for blogs if enabled
		if ($wgEnableBlog) {
			$wgOut->addStyle(wfGetSassUrl('extensions/wikia/Blogs/css/oasis.scss'));
		}

	}
}
