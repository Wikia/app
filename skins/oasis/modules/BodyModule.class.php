<?php
class BodyModule extends Module {

	// global vars
	var $wgBlankImgUrl;
	var $wgSitename;
	var $wgTitle;
	var $wgNoExternals;
	var $wgSuppressWikiHeader;
	var $wgSuppressPageHeader;
	var $wgSuppressRail;
	var $wgSuppressFooter;
	var $wgSuppressArticleCategories;
	var $wgInterlangOnTop;
	var $wgEnableCorporatePageExt;
	var $wgEnableWikiAnswers;
	var $wgABTests;

	// skin vars
	var $content;

	// Module vars
	var $afterBodyHtml;
	var $afterContentHookText;

	var $headerModuleName;
	var $headerModuleAction;
	var $headerModuleParams;
	var $leaderboardToShow;
	var $railModuleList;
	var $displayComments;
	var $noexternals;
	var $displayAdminDashboard;
	var $displayAdminDashboardChromedArticle;
	var $isMainPage;

	private static $onEditPage;
	public static $CORPORATE_LANDING_PAGE_TITLE_METADATA;

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

	public static function isHubPage() {
		global $wgArticle;
		return (get_class ($wgArticle) == "AutoHubsPagesArticle");
	}

	public static function isCorporateLandingPage() {
		global $wgEnableCorporatePageExt, $wgTitle;
		return $wgEnableCorporatePageExt && array_key_exists($wgTitle->getText(), self::$CORPORATE_LANDING_PAGE_TITLE_METADATA);
	}

	public static function getCorporateLandingPageMetadata() {
		global $wgTitle;
		return self::$CORPORATE_LANDING_PAGE_TITLE_METADATA[$wgTitle->getText()];
	}

	/**
	 * Decide whether to show user pages header on current page
	 */
	public static function showUserPagesHeader() {
		wfProfileIn(__METHOD__);

		global $wgTitle, $wgEnableUserProfilePagesV3;

		// perform namespace and special page check
		
		$isUserPage = in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces());

		$ret =  ($isUserPage && empty($wgEnableUserProfilePagesV3))
				|| ($isUserPage && !empty($wgEnableUserProfilePagesV3) && !$wgTitle->isSubpage())
				|| $wgTitle->isSpecial( 'Following' )
				|| $wgTitle->isSpecial( 'Contributions' )
				|| (defined('NS_BLOG_LISTING') && $wgTitle->getNamespace() == NS_BLOG_LISTING) ;

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
		global $wgTitle, $wgUser, $wgEnableAchievementsExt, $wgContentNamespaces,
			$wgEnableWikiaCommentsExt, $wgExtraNamespaces, $wgExtraNamespacesLocal,
			$wgEnableCorporatePageExt, $wgEnableSpotlightsV2_Rail,
			$wgEnableUserProfilePagesExt, $wgABTests, $wgEnableWikiAnswers, $wgEnableWikiReviews,
			$wgEnableBlogsAsClassifieds, $wgSalesTitles, $wgEnableHuluVideoPanel, 
			$wgEnableGamingCalendarExt, $wgEnableUserProfilePagesV3;

		if ($this->wgSuppressRail) {
			return array();
		}

		$railModuleList = array();

		$spotlightsParams = array('mode'=>'RAIL', 'adslots'=> array( 'SPOTLIGHT_RAIL_1', 'SPOTLIGHT_RAIL_2', 'SPOTLIGHT_RAIL_3' ), 'sectionId'=>'WikiaSpotlightsModule', 'adGroupName'=>'SPOTLIGHT_RAIL');

		$namespace = $wgTitle->getNamespace();
		$subjectNamespace = MWNamespace::getSubject($namespace);

		$latestPhotosKey = $wgUser->isAnon() ? 1300 : 1250;
		$latestActivityKey = $wgUser->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $wgUser->isAnon() ? 1390 : 1280;

		if($namespace == NS_SPECIAL) {
			if ($wgTitle->isSpecial('Search')) {
				$railModuleList = array(
					$latestActivityKey => array('LatestActivity', 'Index', null),
				);
				if( empty( $wgEnableWikiReviews ) ) {
					$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
				}

				if( empty( $wgEnableWikiAnswers ) ) {
					$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
					if ($wgEnableHuluVideoPanel) {
						$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
					}
				}

				if($wgEnableSpotlightsV2_Rail) {
					$railModuleList[1150] = array('Spotlights', 'Index', $spotlightsParams);
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
				if( empty( $wgEnableWikiReviews ) ) {
					$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
				}
			} else if ($wgTitle->isSpecial('Following') || $wgTitle->isSpecial('Contributions') ) {
				// intentional nothing here
			} else if ($wgTitle->isSpecial('ThemeDesignerPreview') ) {
				$railModuleList = array (
					1500 => array('Search', 'Index', null),
					$latestActivityKey => array('LatestActivity', 'Index', null),
				);
				if( empty( $wgEnableWikiReviews ) ) {
					$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
				}
				if( empty( $wgEnableWikiAnswers ) ) {
					$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
					if ($wgEnableHuluVideoPanel) {
						$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
					}
				}
				if($wgEnableSpotlightsV2_Rail) {
					$railModuleList[1150] = array('Spotlights', 'Index', $spotlightsParams);
				}
			} else if( $wgTitle->isSpecial('PageLayoutBuilderForm') ) {
					$railModuleList = array (
						1501 => array('Search', 'Index', null),
						1500 => array('PageLayoutBuilderForm', 'Index', null)
					);
			}
			else {
				// don't show any module for MW core special pages
				$railModuleList = array();
				wfRunHooks( 'GetRailModuleSpecialPageList', array( &$railModuleList ) );
				wfProfileOut(__METHOD__);
				return $railModuleList;
			}
		}
		else {
			// search module appears on all pages except search results, where it is added to the body (by BodyModule)
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
			);
		}

		// Content, category and forum namespaces.  FB:1280 Added file,video,mw,template
		if(	(!empty($wgEnableUserProfilePagesV3) && $wgTitle->isSubpage() && $wgTitle->getNamespace() == NS_USER)  ||
			in_array($subjectNamespace, array (NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM, NS_PROJECT, NS_FILE, NS_VIDEO, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP)) ||
			in_array($subjectNamespace, $wgContentNamespaces) ||
			array_key_exists( $subjectNamespace, $wgExtraNamespaces ) ) {
			// add any content page related rail modules here

			$railModuleList[$latestActivityKey] = array('LatestActivity', 'Index', null);
			if( empty( $wgEnableWikiReviews ) ) {
				$railModuleList[1450] = array('PagesOnWiki', 'Index', null);
			}
			if( empty( $wgEnableWikiAnswers ) ) {
				$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
				if ($wgEnableHuluVideoPanel) {
					$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
				}
			}

			if($wgEnableSpotlightsV2_Rail) {
				$railModuleList[1150] = array('Spotlights', 'Index', $spotlightsParams);
			}
		}

		// User page namespaces
		if( empty( $wgEnableUserProfilePagesExt ) && in_array($wgTitle->getNamespace(), self::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName($wgTitle->getText());

			if($page_owner) {
				if( !$page_owner->getOption('hidefollowedpages') ) {
					$railModuleList[1200] = array('FollowedPages', 'Index', null);
				}

				if($wgEnableAchievementsExt && !(($wgUser->getId() == $page_owner->getId()) && $page_owner->getOption('hidepersonalachievements'))){
					$railModuleList[1350] = array('Achievements', 'Index', null);
				}
			}
		}

		if ( self::isBlogPost() || self::isBlogListing()
		  || ( !empty( $wgEnableBlogsAsClassifieds ) && $wgTitle->isContentPage() ) ) {
			$railModuleList[1250] = array('PopularBlogPosts', 'Index', null);
			if($wgEnableSpotlightsV2_Rail) {
				$railModuleList[1150] = array('Spotlights', 'Index', $spotlightsParams);
			}
		}

		// A/B testing leftovers, leave for now because we will do another one
		$useTestBoxad = false;

		// Special case rail modules for Corporate Skin
		if ($wgEnableCorporatePageExt) {
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
			);
			// No rail on main page or edit page for corporate skin
			if ( BodyModule::isEditPage() || ArticleAdLogic::isMainPage() || BodyModule::isCorporateLandingPage() ) {
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
			if ($wgTitle->isSpecial('Search')) $railModuleList = array();
			wfProfileOut(__METHOD__);
			return $railModuleList;
		}
		//  No rail on main page or edit page for oasis skin
		if ( BodyModule::isEditPage() || ArticleAdLogic::isMainPage() ) {
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
		if (!$wgTitle->userCanRead()) {
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
                    
		wfRunHooks( 'GetRailModuleList', array( &$railModuleList ) );

		wfProfileOut(__METHOD__);

		return $railModuleList;
	}


	public function executeIndex() {
		global $wgOut, $wgTitle, $wgSitename, $wgUser, $wgEnableBlog, $wgEnableCorporatePageExt, $wgEnableInfoBoxTest, $wgEnableWikiAnswers, $wgRequest, $wgMaximizeArticleAreaArticleIds, $wgEnableAdminDashboardExt, $wgEnableUserProfilePagesV3;

		// set up global vars
		if (is_array($wgMaximizeArticleAreaArticleIds)
		&& in_array($wgTitle->getArticleId(), $wgMaximizeArticleAreaArticleIds)) {
			$this->wgSuppressRail = true;
			$this->wgSuppressPageHeader = true;
		}

		// InfoBox - Testing
		$this->wgEnableInfoBoxTest = $wgEnableInfoBoxTest;
		$this->isMainPage = ArticleAdLogic::isMainPage();

		$this->bodytext = Module::get('ContentDisplay')->getData('bodytext');

		$this->railModuleList = $this->getRailModuleList();
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		wfRunHooks('GetHTMLAfterBody', array ($wgUser->getSkin(), &$this->afterBodyHtml));

		// this hook is needed for SMW's factbox
		if (!wfRunHooks('SkinAfterContent', array( &$this->afterContentHookText ) )) {
			$this->afterContentHookText = '';
		}

		$this->headerModuleAction = 'Index';
		$this->headerModuleParams = array ('showSearchBox' => false);

		// Display comments on content and blog pages
		if ( class_exists('ArticleCommentInit') && ArticleCommentInit::ArticleCommentCheck() ) {
			$this->displayComments = true;
		} else {
			$this->displayComments = false;
		}

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

			// FIXME: move to separate module
			if ($wgEnableCorporatePageExt) {

				// RT:71681 AutoHubsPages extension is skipped when follow is clicked
				wfLoadExtensionMessages( 'AutoHubsPages' );

				$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("extensions/wikia/CorporatePage/css/CorporateSite.scss"));

				global $wgExtensionsPath, $wgJsMimeType;
				$wgOut->addScript("<script src=\"{$wgExtensionsPath}/wikia/CorporatePage/js/CorporateSlider.js\" type=\"{$wgJsMimeType}\"></script>");

				// $this->wgSuppressFooter = true;
				$this->wgSuppressArticleCategories = true;
				$this->displayComments = false;
				if (ArticleAdLogic::isMainPage()) {
					$this->wgSuppressPageHeader = true;
				} else {
					$this->headerModuleAction = 'Corporate';
				}

				// Facebook Open Graph metadata
				if (self::isCorporateLandingPage()) {
					$metadata = BodyModule::getCorporateLandingPageMetadata();
					$urlChunks = explode('?', $wgRequest->getFullRequestURL());
					$wgOut->addMeta('property:og:url', $urlChunks[0]);
					$wgOut->addMeta('property:og:type', $metadata['type']);
					$wgOut->addMeta('property:og:title', $metadata['title']);
					$wgOut->addMeta('description', $metadata['description']);
					$wgOut->addMeta('property:og:image', $metadata['image']);
				}
			}
		}

		// use one column layout for pages with no right rail modules
		if (count($this->railModuleList ) == 0) {
			OasisModule::addBodyClass('oasis-one-column');
			$this->headerModuleParams = array ('showSearchBox' => true);
		}

		// if we are on a special search page, pull in the css file and don't render a header
		if($wgTitle && $wgTitle->isSpecial( 'Search' )) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/SpecialSearch.scss"));
			$this->headerModuleName = null;
			$this->bodytext = wfRenderModule('Search') . $this->bodytext;
		}

		// load CSS for Special:Preferences
		if (!empty($wgTitle) && $wgTitle->isSpecial('Preferences')) {
			$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialPreferences.scss'));
		}

		// Display Control Center Header on certain special pages
		if (!empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this->app, $wgTitle)) {
			$this->headerModuleName = null;
			$this->wgSuppressAds = true;
			$this->wgSuppressWikiHeader = true;
			$this->displayAdminDashboard = true;
			$this->displayAdminDashboardChromedArticle = ($wgTitle->getText() != Title::newFromText("AdminDashboard", NS_SPECIAL)->getText());
			if($this->displayAdminDashboardChromedArticle) {
				$state = F::app()->sendRequest( 'AdminDashboardSpecialPage', 'getDrawerState', array())->getData();
				$this->adminDashboardCollapsed = $state['state'] == 'true';
			}
		} else {
			$this->displayAdminDashboard = false;
			$this->displayAdminDashboardChromedArticle = false;
		}
		
		$this->isUserProfilePageV3Enabled = !empty($wgEnableUserProfilePagesV3);

	}
}

BodyModule::$CORPORATE_LANDING_PAGE_TITLE_METADATA =
	array(
	    'Trivia' => array('type'=>'article', 'title'=>wfMsg('corporatelandingpage-trivia-title'), 'description'=>wfMsg('corporatelandingpage-trivia-description'), 'image'=>'http://images.will.wikia-dev.com/wikiaglobal/images/2/2b/Trivia_bug.png')
	);
