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

	/**
	 * Returns if current layout should be applying gridlayout
	 */
	public static function isGridLayoutEnabled() {
		if ( self::isOasisBreakpoints( ) ) {
			return false;
		}

		$app = F::app();

		// Don't enable when responsive layout is enabled
		if ( self::isResponsiveLayoutEnabled() ) {
			return false;
		}

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
	 * @return Boolean
	 */
	public static function isOasisBreakpoints() {
		global $wgOasisBreakpoints, $wgRequest;

		$wgOasisBreakpoints = $wgRequest->getBool( 'oasisbreakpoints', $wgOasisBreakpoints ) !== false;
		return !empty( $wgOasisBreakpoints );
	}

	/**
	 * Decide on which pages responsive / liquid layout should be turned on.
	 * @return Boolean
	 */
	public static function isResponsiveLayoutEnabled() {
		global $wgOasisResponsive;

		return !self::isOasisBreakpoints() && !empty( $wgOasisResponsive );
	}

	public static function isOasisTypography() {
		global $wgOasisTypography, $wgRequest;

		$wgOasisTypography = $wgRequest->getBool( 'oasistypography', $wgOasisTypography ) !== false;
		return !empty( $wgOasisTypography );
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
				|| $wgTitle->isSpecial( 'UserActivity' )
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
			$wgEnableWikiAnswers, $wgEnableHuluVideoPanel,
			$wgEnableWallEngine, $wgRequest,
			$wgEnableForumExt;

		$namespace = $wgTitle->getNamespace();
		$subjectNamespace = MWNamespace::getSubject($namespace);

		$railModuleList = array();

		$latestActivityKey = $wgUser->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $wgUser->isAnon() ? 1390 : 1280;

		// Forum Extension
		if ($wgEnableForumExt && ForumHelper::isForum()) {
			$railModuleList = array (
				1202 => array('Forum', 'forumRelatedThreads', null),
				1201 => array('Forum', 'forumActivityModule', null),
				1490 => array('Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD']),
			);

			// Include additional modules from other extensions (like chat)
			wfRunHooks( 'GetRailModuleList', array( &$railModuleList ) );

			wfProfileOut(__METHOD__);
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
						if ($wgEnableHuluVideoPanel) {
							$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
						}
					}
				}
			} else if ($wgTitle->isSpecial('Leaderboard')) {
				$railModuleList = array (
					$latestActivityKey => array('LatestActivity', 'Index', null),
					1290 => array('LatestEarnedBadges', 'Index', null)
				);
			} else if ($wgTitle->isSpecial('WikiActivity')) {
				$railModuleList = array (
					1102 => array('HotSpots', 'Index', null),
					1101 => array('CommunityCorner', 'Index', null)
			);
				$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
			} else if ($wgTitle->isSpecial('Following') || $wgTitle->isSpecial('Contributions') ) {
				// intentional nothing here
			} else if ($wgTitle->isSpecial('ThemeDesignerPreview') ) {
				$railModuleList = array (
					$latestActivityKey => array('LatestActivity', 'Index', null),
				);

				$railModuleList[1450] = array('PagesOnWiki', 'Index', null);

				if( empty( $wgEnableWikiAnswers ) ) {
					if ($wgEnableHuluVideoPanel) {
						$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
					}
				}
			} else {
				// don't show any module for MW core special pages
				$railModuleList = array();
				wfRunHooks( 'GetRailModuleSpecialPageList', array( &$railModuleList ) );
				wfProfileOut(__METHOD__);
				return $railModuleList;
			}
		}

		// Content, category and forum namespaces.  FB:1280 Added file,video,mw,template
		if(	$wgTitle->isSubpage() && $wgTitle->getNamespace() == NS_USER ||
			in_array($subjectNamespace, array (NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM, NS_PROJECT, NS_FILE, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP)) ||
			in_array($subjectNamespace, $wgContentNamespaces) ||
			array_key_exists( $subjectNamespace, $wgExtraNamespaces ) ) {
			// add any content page related rail modules here

			$railModuleList[$latestActivityKey] = array('LatestActivity', 'Index', null);
			$railModuleList[1450] = array('PagesOnWiki', 'Index', null);

			if( empty( $wgEnableWikiAnswers ) ) {
				if ($wgEnableHuluVideoPanel) {
					$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
				}
			}
		}

		// User page namespaces
		if( in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName($wgTitle->getText());

			if($page_owner) {
				if ( !$page_owner->getGlobalPreference('hidefollowedpages') ) {
					$railModuleList[1101] = array('FollowedPages', 'Index', null);
				}

				if ( $wgEnableAchievementsExt ) {
					$railModuleList[1102] = array('Achievements', 'Index', null);
				}
			}
		}

		if (self::isBlogPost() || self::isBlogListing()) {
			$railModuleList[1250] = array('PopularBlogPosts', 'Index', null);
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

		$railModuleList[1440] = array('Ad', 'Index', ['slotName' => 'TOP_RIGHT_BOXAD']);
		$railModuleList[1435] = array('AdEmptyContainer', 'Index', ['slotName' => 'NATIVE_TABOOLA_RAIL']);
		$railModuleList[1100] = array('Ad', 'Index', ['slotName' => 'LEFT_SKYSCRAPER_2']);

		unset($railModuleList[1450]);

		wfRunHooks( 'GetRailModuleList', array( &$railModuleList ) );

		wfProfileOut(__METHOD__);

		return $railModuleList;
	}


	public function executeIndex() {
		global $wgOut, $wgTitle, $wgEnableInfoBoxTest, $wgMaximizeArticleAreaArticleIds, $wgEnableAdminDashboardExt, $wgEnableWikiaHomePageExt;

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

		$beforeWikiaPageHtml = '';
		wfRunHooks('GetHTMLBeforeWikiaPage', array(&$beforeWikiaPageHtml));
		$this->beforeWikiaPageHtml = $beforeWikiaPageHtml;


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
		// show corporate header on this page?
		} else if( WikiaPageType::isCorporatePage() || WikiaPageType::isWikiaHub()) {
			$this->headerModuleName = 'PageHeader';

			if( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			} else {
				$this->headerModuleAction = 'Corporate';
			}

			if ( WikiaPageType::isWikiaHubMain() ) {
				$this->headerModuleAction = 'Hubs';
			}
			// FIXME: move to separate module
			elseif( WikiaPageType::isMainPage() ) {
				$this->wg->SuppressFooter = true;
				$this->wg->SuppressArticleCategories = true;
				$this->wg->SuppressPageHeader = true;
				$this->wg->SuppressWikiHeader = true;
				$this->wg->SuppressSlider = true;
			}
		} else {
			$this->headerModuleName = 'PageHeader';
			if( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			}
		}

		// Display Control Center Header on certain special pages
		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->headerModuleName = null;
			$this->displayAdminDashboard = true;
			$this->displayAdminDashboardChromedArticle = ($wgTitle->getText() != SpecialPage::getTitleFor( 'AdminDashboard' )->getText());
		} else {
			$this->displayAdminDashboard = false;
			$this->displayAdminDashboardChromedArticle = false;
		}

		$this->railModulesExist = true;

		// use one column layout for pages with no right rail modules
		if( count($this->railModuleList ) == 0 || !empty($this->wg->SuppressRail) ) {
			// Special:AdminDashboard doesn't need this class, but pages chromed with it do
			if ( !$this->displayAdminDashboard || $this->displayAdminDashboardChromedArticle ) {
				OasisController::addBodyClass('oasis-one-column');
			}

			$this->headerModuleParams = array ('showSearchBox' => true);
			$this->railModulesExist = false;
		}

		// determine if WikiaGridLayout needs to be enabled
		$this->isGridLayoutEnabled = self::isGridLayoutEnabled();
		if($this->isGridLayoutEnabled) {
			OasisController::addBodyClass('wikia-grid');
		}

		if( $this->isOasisBreakpoints() ) {
			OasisController::addBodyClass( 'oasis-breakpoints' );
		}

		//@TODO remove this check after deprecating responsive (July 2015)
		if( $this->isResponsiveLayoutEnabled() ) {
			OasisController::addBodyClass( 'oasis-responsive' );
		}

		// if we are on a special search page, pull in the css file and don't render a header
		if($wgTitle && $wgTitle->isSpecial( 'Search' ) && !$this->wg->WikiaSearchIsDefault) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/SpecialSearch.scss"));
			$this->headerModuleName = null;
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

		// load CSS for Special:MultipleUpload
		if (!empty($wgTitle) && $wgTitle->isSpecial('MultipleUpload')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialMultipleUpload.scss'));
		}

		// load CSS for Special:Allpages
		if (!empty($wgTitle) && $wgTitle->isSpecial('Allpages')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialAllpages.scss'));
		}

		// Forum Extension
		if (!empty($this->wg->EnableForumExt) && ForumHelper::isForum()) {
			$this->wg->SuppressPageHeader = true;
		}

		// MonetizationModule Extension
		if ( !empty( $this->wg->EnableMonetizationModuleExt ) ) {
			if ( empty( $this->wg->AdDriverUseMonetizationService ) ) {
				$this->monetizationModules = $this->sendRequest( 'MonetizationModule', 'index' )->getData()['data'];
				$this->headerModuleParams['monetizationModules'] = $this->monetizationModules;
			} else {
				$this->monetizationModules = [
					MonetizationModuleHelper::SLOT_TYPE_IN_CONTENT => $this->app->renderView( 'Ad', 'Index', ['slotName' => 'MON_IN_CONTENT'] ),
					MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY => $this->app->renderView( 'Ad', 'Index', ['slotName' => 'MON_BELOW_CATEGORY'] ),
				];
			}
			$this->bodytext = MonetizationModuleHelper::insertIncontentUnit( $this->bodytext, $this->monetizationModules );
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

		// bugid-70243: optionally hide navigation h1s for SEO
		$this->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );

		wfProfileOut(__METHOD__);
	}

}
