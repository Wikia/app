<?php
class BodyController extends WikiaController {

	private static $onEditPage;

	public function init() {
		$this->subtitle = $this->app->getSkinTemplateObj()->data['subtitle'];

		$this->afterBodyHtml = '';
		$this->afterContentHookText = '';
		$this->afterCommentsHookText = '';
	}
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
			!is_null($wgRequest->getVal('diff')) /* diff pages - RT #69931 */ ||
			in_array($wgRequest->getVal('action', 'view'), array('edit' /* view source page */, 'formedit' /* SMW edit pages */, 'history' /* history pages */, 'submit' /* conflicts, etc */));
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

	public static function isHubPage() {
		global $wgArticle;
		return (get_class ($wgArticle) == "AutoHubsPagesArticle");
	}

	/**
	 * Returns if current layout should be applying gridlayout
	 */
	public static function isGridLayoutEnabled() {
		$app = F::app();
		
		if( !empty($app->wg->OasisGrid) ) {
			return true;
		}

		$ns = $app->wg->Title->getNamespace();

		if( in_array( MWNamespace::getSubject($ns), $app->wg->WallNS) ) {
			return true;
		}

		if( defined("NS_WIKIA_FORUM_TOPIC_BOARD") && $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			return true;
		}
		
		return false;
	}

	/**
	 * Decide whether to show user pages header on current page
	 */
	public static function showUserPagesHeader() {
		wfProfileIn(__METHOD__);

		global $wgTitle;

		// perform namespace and special page check
		$isUserPage = in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces());

		$ret = ($isUserPage && !$wgTitle->isSubpage() )
				|| $wgTitle->isSpecial( 'Following' )
				|| $wgTitle->isSpecial( 'Contributions' )
				|| (defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING)
				|| (defined('NS_BLOG_ARTICLE') && $wgTitle->getNamespace() == NS_BLOG_ARTICLE);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Return list of namespaces on which user pages header should be shown
	 */
	public static function getUserPagesNamespaces() {
		global $wgEnableWallExt;

		$namespaces = array(NS_USER);
		if( empty($wgEnableWallExt) ) {
			$namespaces[] = NS_USER_TALK;
		}
		if (defined('NS_BLOG_ARTICLE')) {
			$namespaces[] = NS_BLOG_ARTICLE;
		}
		if (defined('NS_BLOG_LISTING')) {
			// FIXME: THIS IS NOT REALLY PART OF THE USER PAGES NAMESPACES
			//$namespaces[] = NS_BLOG_LISTING;
		}
		if (defined('NS_USER_WALL')) {
			$namespaces[] = NS_USER_WALL;
		}
		return $namespaces;
	}

	public function getRailModuleList() {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgUser, $wgEnableAchievementsExt, $wgContentNamespaces,
			$wgExtraNamespaces, $wgExtraNamespacesLocal,
			$wgEnableCorporatePageExt,
			$wgEnableWikiAnswers,
			$wgSalesTitles, $wgEnableHuluVideoPanel,
			$wgEnableGamingCalendarExt, $wgEnableWallEngine, $wgRequest;

		$namespace = $wgTitle->getNamespace();
		$subjectNamespace = MWNamespace::getSubject($namespace);

		$railModuleList = array();

		$latestPhotosKey = $wgUser->isAnon() ? 1300 : 1250;
		$latestActivityKey = $wgUser->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $wgUser->isAnon() ? 1390 : 1280;

		// Forum Extension
		if (WikiaPageType::isForum()) {
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
				1002 => array('Forum', 'forumRelatedThreads', null),
				1001 => array('Forum', 'forumActivityModule', null),
				1000 => array('Forum', 'forumParticipationModule', null),
				1490 => array('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BOXAD')),
			);
			return $railModuleList;
		}

		if($namespace == NS_SPECIAL) {
			if (WikiaPageType::isSearch()) {
				if (empty($this->wg->EnableWikiaHomePageExt)) {
					$railModuleList = array(
						$latestActivityKey => array('LatestActivity', 'Index', null),
					);

					$railModuleList[1450] = array('PagesOnWiki', 'Index', null);

					if( empty( $wgEnableWikiAnswers ) ) {
						$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
						if ($wgEnableHuluVideoPanel) {
							$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
						}
					}
				} elseif ($wgEnableCorporatePageExt) {
					$railModuleList = array(
						1490 => array('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BOXAD'))
					);
					wfProfileOut(__METHOD__);
					return $railModuleList;
				}
			} else if ($wgTitle->isSpecial('Leaderboard')) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					$latestActivityKey => array('LatestActivity', 'Index', null),
					1290 => array('LatestEarnedBadges', 'Index', null)
				);
			} else if ($wgTitle->isSpecial('WikiActivity')) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					1102 => array('HotSpots', 'Index', null),
					1101 => array('CommunityCorner', 'Index', null),
				);
				$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
			} else if ($wgTitle->isSpecial('Following') || $wgTitle->isSpecial('Contributions') ) {
				// intentional nothing here
			} else if ($wgTitle->isSpecial('ThemeDesignerPreview') ) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					$latestActivityKey => array('LatestActivity', 'Index', null),
				);

				$railModuleList[1450] = array('PagesOnWiki', 'Index', null);

				if( empty( $wgEnableWikiAnswers ) ) {
					$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
					if ($wgEnableHuluVideoPanel) {
						$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
					}
				}
			} else if( $wgTitle->isSpecial('PageLayoutBuilderForm') ) {
				$railModuleList = array (
					1501 => array('Search', 'Index', null),
					1500 => array('PageLayoutBuilderForm', 'Index', null)
				);
			} else {
				// don't show any module for MW core special pages
				$railModuleList = array();
				wfRunHooks( 'GetRailModuleSpecialPageList', array( &$railModuleList ) );
				wfProfileOut(__METHOD__);
				return $railModuleList;
			}
		} else if ( !self::showUserPagesHeader() ) {
			// ProfilePagesV3 renders its own search box.
			// If this page is not a page with the UserPagesHeader on version 3, show search (majority case)
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
			);
		}

		// Content, category and forum namespaces.  FB:1280 Added file,video,mw,template
		if(	$wgTitle->isSubpage() && $wgTitle->getNamespace() == NS_USER ||
			in_array($subjectNamespace, array (NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM, NS_PROJECT, NS_FILE, NS_VIDEO, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP)) ||
			in_array($subjectNamespace, $wgContentNamespaces) ||
			array_key_exists( $subjectNamespace, $wgExtraNamespaces ) ) {
			// add any content page related rail modules here

			$railModuleList[$latestActivityKey] = array('LatestActivity', 'Index', null);
			$railModuleList[1450] = array('PagesOnWiki', 'Index', null);

			if( empty( $wgEnableWikiAnswers ) ) {
				$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
				if ($wgEnableHuluVideoPanel) {
					$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
				}
			}
		}

		// User page namespaces
		if( in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName($wgTitle->getText());

			if($page_owner) {
				if( !$page_owner->getOption('hidefollowedpages') ) {
					$railModuleList[1101] = array('FollowedPages', 'Index', null);
				}

				if($wgEnableAchievementsExt && !(($wgUser->getId() == $page_owner->getId()) && $page_owner->getOption('hidepersonalachievements'))){
					$railModuleList[1102] = array('Achievements', 'Index', null);
				}
			}
		}

		if (self::isBlogPost() || self::isBlogListing()) {
			$railModuleList[1500] = array('Search', 'Index', null);
			$railModuleList[1250] = array('PopularBlogPosts', 'Index', null);
		}

		// A/B testing leftovers, leave for now because we will do another one
		$useTestBoxad = false;

		// Special case rail modules for Corporate Skin
		if ($wgEnableCorporatePageExt) {
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
			);
			// No rail on main page or edit page for corporate skin
			if ( BodyController::isEditPage() || WikiaPageType::isMainPage() ) {
				$railModuleList = array();
			}
			else if (self::isHubPage()) {
				if ($useTestBoxad) {
					$railModuleList[1490] = array('Ad', 'Index', array('slotname' => 'TEST_TOP_RIGHT_BOXAD'));
				}
				else {
					$railModuleList[1490] = array('Ad', 'Index', array('slotname' => 'CORP_TOP_RIGHT_BOXAD'));
				}
				$railModuleList[1480] = array('CorporateSite', 'HotSpots', null);
			//	$railModuleList[1470] = array('CorporateSite', 'PopularHubPosts', null);  // temp disabled - data not updating
				$railModuleList[1460] = array('CorporateSite', 'TopHubUsers', null);
			} else if ( is_array( $wgSalesTitles ) && in_array( $wgTitle->getText(), $wgSalesTitles ) ){
				$railModuleList[1470] = array('CorporateSite', 'SalesSupport', null);
			} else { // content pages
				$railModuleList[1470] = array('CorporateSite', 'PopularStaffPosts', null);
			}
			wfProfileOut(__METHOD__);
			return $railModuleList;
		}

		//  No rail on main page or edit page for oasis skin
		// except &action=history of wall
		if( !empty($wgEnableWallEngine) ) {
			$isEditPage = !WallHelper::isWallNamespace($namespace) && BodyController::isEditPage() || $wgRequest->getVal('diff');
		} else {
			$isEditPage = BodyController::isEditPage();
		}

		if ( $isEditPage || WikiaPageType::isMainPage() ) {
			$modules = array();
			wfRunHooks( 'GetEditPageRailModuleList', array( &$modules ) );
			wfProfileOut(__METHOD__);
			return $modules;
		}
		// No modules on Custom namespaces, unless they are in the ContentNamespaces list, those get the content rail
		if (is_array($wgExtraNamespacesLocal) && array_key_exists($subjectNamespace, $wgExtraNamespacesLocal) && !in_array($subjectNamespace, $wgContentNamespaces)) {
			wfProfileOut(__METHOD__);
			return array();
		}
		// If the entire page is non readable due to permissions, don't display the rail either RT#75600
		if (!$wgTitle->userCan( 'read' )) {
			wfProfileOut(__METHOD__);
			return array();
		}

		if ($useTestBoxad) {
			$railModuleList[1440] = array('Ad', 'Index', array('slotname' => 'TEST_TOP_RIGHT_BOXAD'));
		}
		else {
			$railModuleList[1440] = array('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BOXAD'));
		}
		$railModuleList[1291] = array('Ad', 'Index', array('slotname' => 'MIDDLE_RIGHT_BOXAD'));
		$railModuleList[1100] = array('Ad', 'Index', array('slotname' => 'LEFT_SKYSCRAPER_2'));

		/**
		 * Michał Roszka <michal@wikia-inc.com>
		 *
		 * SSW Gaming Calendar
		 *
		 * This is most likely going to be replaced with something similar to:
		 *
		 * $railModuleList[1260] = array( 'Ad', 'Index', array( 'slotname' => 'GAMING_CALENDAR_RAIL' ) );
		 */
		if ( !empty( $wgEnableGamingCalendarExt ) ) {
			$railModuleList[1430] = array( 'GamingCalendarRail', 'Index', array( ) );
		}
		else {
			$railModuleList[1430] = array('Ad', 'Index', array('slotname' => 'TOP_RIGHT_BUTTON'));
		}

		// WikiNav v2 - begin
		// TODO: remove once it's enabled sitewide
		global $wgOasisNavV2;
		if (!empty($wgOasisNavV2)) {
			// remove PagesOnWiki module
			unset($railModuleList[1450]);
		}
		// WikiNav v2 - end

		wfRunHooks( 'GetRailModuleList', array( &$railModuleList ) );

		wfProfileOut(__METHOD__);

		return $railModuleList;
	}


	public function executeIndex() {
		global $wgOut, $wgTitle, $wgUser, $wgEnableCorporatePageExt, $wgEnableInfoBoxTest, $wgMaximizeArticleAreaArticleIds, $wgEnableAdminDashboardExt, $wgEnableTopButton, $wgTopButtonPosition, $wgEnableWikiaHomePageExt;

		wfProfileIn(__METHOD__);

		// set up global vars
		if (is_array($wgMaximizeArticleAreaArticleIds)
		&& in_array($wgTitle->getArticleId(), $wgMaximizeArticleAreaArticleIds)) {
			$this->wg->SuppressRail = true;
			$this->wg->SuppressPageHeader = true;
		}

		// Double-click to edit
		$this->body_ondblclick = ''; // FIXME handling moved to OutputPage::addDefaultModules()

		// InfoBox - Testing
		$this->wg->EnableInfoBoxTest = $wgEnableInfoBoxTest;
		$this->isMainPage = WikiaPageType::isMainPage();

		// Replaces ContentDisplayModule->index()
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];

		$this->railModuleList = $this->getRailModuleList();
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		$skin = RequestContext::getMain()->getSkin();
		$afterBodyHtml = '';
		wfRunHooks('GetHTMLAfterBody', array($skin, &$afterBodyHtml));
		$this->afterBodyHtml = $afterBodyHtml;

		// this hook is needed for SMW's factbox
		$afterContentHookText = '';
		wfRunHooks('SkinAfterContent', array( &$afterContentHookText ) );
		$this->afterContentHookText = $afterContentHookText;

		$this->headerModuleAction = 'Index';
		$this->headerModuleParams = array ('showSearchBox' => false);

		// show user pages header on this page?
		if (self::showUserPagesHeader()) {
			$this->headerModuleName = 'UserPagesHeader';
			// is this page a blog post?
			if( self::isBlogPost() ) {
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

			// FIXME: move to separate module
			if ( $wgEnableWikiaHomePageExt && WikiaPageType::isMainPage() ) {
				$this->wg->SuppressFooter = true;
				$this->wg->SuppressArticleCategories = true;
				$this->wg->SuppressPageHeader = true;
				$this->wg->SuppressWikiHeader = true;
				$this->wg->SuppressSlider = true;
			} else if ($wgEnableCorporatePageExt) {
				// RT:71681 AutoHubsPages extension is skipped when follow is clicked

				$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("extensions/wikia/CorporatePage/css/CorporateSite.scss"));

				global $wgExtensionsPath, $wgJsMimeType;
				$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/CorporatePage/js/CorporateSlider.js\" type=\"{$wgJsMimeType}\"></script>");

				// $this->wgSuppressFooter = true;
				$this->wgSuppressArticleCategories = true;
				if (WikiaPageType::isMainPage()) {
					$this->wg->SuppressPageHeader = true;
				} else {
					$this->headerModuleAction = 'Corporate';
				}
			}
		}

		$this->railModulesExist = true;

		// use one column layout for pages with no right rail modules
		if( count($this->railModuleList ) == 0 || !empty($this->wg->SuppressRail) ) {
			OasisController::addBodyClass('oasis-one-column');
			$this->headerModuleParams = array ('showSearchBox' => true);
			$this->railModulesExist = false;
		}

		// determine if WikiaGridLayout needs to be enabled
		$this->isGridLayoutEnabled = self::isGridLayoutEnabled();
		if($this->isGridLayoutEnabled) {
			OasisController::addBodyClass('wikia-grid');
		}

		// if we are on a special search page, pull in the css file and don't render a header
		if($wgTitle && $wgTitle->isSpecial( 'Search' ) && !$this->wg->WikiaSearchIsDefault) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/SpecialSearch.scss"));
			$this->headerModuleName = null;
			$this->bodytext = F::app()->renderView('Search', "Index'") . $this->bodytext;
		}

		// Inter-wiki search
		if($wgTitle && ($wgTitle->isSpecial( 'WikiaSearch' ) || ($wgTitle->isSpecial( 'Search' ) && $this->wg->WikiaSearchIsDefault ))) {
			$this->headerModuleName = null;
		}

		// load CSS for Special:Preferences
		if (!empty($wgTitle) && $wgTitle->isSpecial('Preferences')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialPreferences.scss'));
		}

		// load CSS for Special:Upload
		if (!empty($wgTitle) && $wgTitle->isSpecial('Upload')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialUpload.scss'));
		}

		// load CSS for Special:Allpages
		if (!empty($wgTitle) && $wgTitle->isSpecial('Allpages')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialAllpages.scss'));
		}

		// Display Control Center Header on certain special pages
		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->headerModuleName = null;
			$this->wgSuppressAds = true;
			$this->displayAdminDashboard = true;
			$this->displayAdminDashboardChromedArticle = ($wgTitle->getText() != Title::newFromText("AdminDashboard", NS_SPECIAL)->getText());
		} else {
			$this->displayAdminDashboard = false;
			$this->displayAdminDashboardChromedArticle = false;
		}

		// Forum Extension
		if (!empty($this->wg->EnableForumExt) && !empty($this->wg->IsForum)) {
			$this->wg->SuppressPageHeader = true;
		}

		$namespace = $wgTitle->getNamespace();
		// extra logic for subpages (RT #74091)
		if (!empty($this->subtitle)) {
			switch($namespace) {
				// for user subpages add link to theirs talk pages
				case NS_USER:
					$talkPage = $wgTitle->getTalkPage();

					// get number of revisions for talk page
					$service = new PageStatsService($wgTitle->getArticleId());
					$comments = $service->getCommentsCount();

					// render comments bubble
					$bubble = F::app()->renderView('CommentsLikes', 'Index', array('comments' => $comments, 'bubble' => true));

					$this->subtitle .= ' | ';
					$this->subtitle .= $bubble;
					$this->subtitle .= Wikia::link($talkPage);
					break;

				case NS_USER_TALK:
					$subjectPage = $wgTitle->getSubjectPage();

					$this->subtitle .= ' | ';
					$this->subtitle .= Wikia::link($subjectPage);
					break;
			}
		}

		wfProfileOut(__METHOD__);
	}

}
