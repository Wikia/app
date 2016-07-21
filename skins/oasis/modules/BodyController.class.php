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
	public static function onEditPageRender() {
		self::$onEditPage = true;
		return true;
	}

	/**
	 * Detect we're on edit (or diff) page
	 */
	public static function isEditPage() {
		$wg = F::app()->wg;
		return !empty( self::$onEditPage ) ||
		!is_null( $wg->Request->getVal( 'diff' ) ) /* diff pages - RT #69931 */ ||
		in_array( $wg->Request->getVal( 'action', 'view' ), [ 'edit' /* view source page */, 'formedit' /* SMW edit pages */, 'history' /* history pages */, 'submit' /* conflicts, etc */ ] );
	}

	/**
	 * Check whether current page is blog post
	 */
	public static function isBlogPost() {
		$wg = F::app()->wg;
		return defined( 'NS_BLOG_ARTICLE' ) && $wg->Title->getNamespace() == NS_BLOG_ARTICLE && $wg->Title->isSubpage();
	}

	/**
	 * Check whether current page is blog listing
	 */
	public static function isBlogListing() {
		return defined( 'NS_BLOG_LISTING' ) && F::app()->wg->Title->getNamespace() == NS_BLOG_LISTING;
	}

	/**
	 * Returns if current layout should be applying gridlayout
	 */
	public static function isGridLayoutEnabled() {
		if ( self::isOasisBreakpoints() ) {
			return false;
		}

		$wg = F::app()->wg;

		// Don't enable when responsive layout is enabled
		if ( self::isResponsiveLayoutEnabled() ) {
			return false;
		}

		if ( !empty( $wg->OasisGrid ) ) {
			return true;
		}

		$ns = $wg->Title->getNamespace();

		if ( in_array( MWNamespace::getSubject( $ns ), $wg->WallNS ) ) {
			return true;
		}

		if ( defined( "NS_WIKIA_FORUM_TOPIC_BOARD" ) && $ns == NS_WIKIA_FORUM_TOPIC_BOARD ) {
			return true;
		}

		return false;
	}

	/**
	 * @return Boolean
	 */
	public static function isOasisBreakpoints() {
		$wg = F::app()->wg;

		$wg->OasisBreakpoints = $wg->Request->getBool( 'oasisbreakpoints', $wg->OasisBreakpoints ) !== false;
		return !empty( $wg->OasisBreakpoints );
	}

	/**
	 * Decide on which pages responsive / liquid layout should be turned on.
	 * @return Boolean
	 */
	public static function isResponsiveLayoutEnabled() {
		return !self::isOasisBreakpoints() && !empty( F::app()->wg->OasisResponsive );
	}

	public static function isOasisTypography() {
		$wg = F::app()->wg;

		$wg->OasisTypography = $wg->Request->getBool( 'oasistypography', $wg->OasisTypography ) !== false;
		return !empty( $wg->OasisTypography );
	}

	/**
	 * Decide whether to show user pages header on current page
	 */
	public static function showUserPagesHeader() {
		$wg = F::app()->wg;

		// perform namespace and special page check
		$isUserPage = in_array( $wg->Title->getNamespace(), self::getUserPagesNamespaces() );

		$ret = ( $isUserPage && !$wg->Title->isSubpage() )
			|| $wg->Title->isSpecial( 'Following' )
			|| $wg->Title->isSpecial( 'Contributions' )
			|| $wg->Title->isSpecial( 'UserActivity' )
			|| ( defined( 'NS_BLOG_LISTING' ) && $wg->Title->getNamespace() == NS_BLOG_LISTING )
			|| ( defined( 'NS_BLOG_ARTICLE' ) && $wg->Title->getNamespace() == NS_BLOG_ARTICLE );

		return $ret;
	}

	/**
	 * Return list of namespaces on which user pages header should be shown
	 */
	public static function getUserPagesNamespaces() {
		$namespaces = [ NS_USER ];
		if ( empty( F::app()->wg->EnableWallExt ) ) {
			$namespaces[] = NS_USER_TALK;
		}

		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$namespaces[] = NS_BLOG_ARTICLE;
		}

		if ( defined( 'NS_USER_WALL' ) ) {
			$namespaces[] = NS_USER_WALL;
		}
		return $namespaces;
	}

	public function getRailModuleList() {
		$namespace = $this->wg->Title->getNamespace();
		$subjectNamespace = MWNamespace::getSubject( $namespace );

		$railModuleList = [ ];

		$latestActivityKey = $this->wg->User->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $this->wg->User->isAnon() ? 1390 : 1280;

		// Forum Extension
		if ( $this->wg->EnableForumExt && ForumHelper::isForum() ) {
			$railModuleList = [
				1202 => [ 'Forum', 'forumRelatedThreads', null ],
				1201 => [ 'Forum', 'forumActivityModule', null ],
				1490 => [ 'Ad', 'Index', [ 'slotName' => 'TOP_RIGHT_BOXAD' ] ],
			];

			// Include additional modules from other extensions (like chat)
			wfRunHooks( 'GetRailModuleList', [ &$railModuleList ] );
			return $railModuleList;
		}

		if ( $namespace == NS_SPECIAL ) {
			if ( WikiaPageType::isSearch() ) {
				if ( empty( $this->wg->EnableWikiaHomePageExt ) ) {
					$railModuleList = [
						$latestActivityKey => [ 'LatestActivity', 'Index', null ],
					];

					$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

					if ( empty( $this->wg->EnableWikiAnswers ) ) {
						if ( $this->wg->EnableHuluVideoPanel ) {
							$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
						}
					}
				}
			} else if ( $this->wg->Title->isSpecial( 'Leaderboard' ) ) {
				$railModuleList = [
					$latestActivityKey => [ 'LatestActivity', 'Index', null ],
					1290               => [ 'LatestEarnedBadges', 'Index', null ],
				];
			} else if ( $this->wg->Title->isSpecial( 'WikiActivity' ) ) {
				$railModuleList = [
					1102 => [ 'HotSpots', 'Index', null ],
					1101 => [ 'CommunityCorner', 'Index', null ],
				];
				$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];
			} else if ( $this->wg->Title->isSpecial( 'Following' ) || $this->wg->Title->isSpecial( 'Contributions' ) ) {
				// intentional nothing here
			} else if ( $this->wg->Title->isSpecial( 'ThemeDesignerPreview' ) ) {
				$railModuleList = [
					$latestActivityKey => [ 'LatestActivity', 'Index', null ],
				];

				$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

				if ( empty( $this->wg->EnableWikiAnswers ) ) {
					if ( $this->wg->EnableHuluVideoPanel ) {
						$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
					}
				}
			} else {
				// don't show any module for MW core special pages
				$railModuleList = [ ];
				wfRunHooks( 'GetRailModuleSpecialPageList', [ &$railModuleList ] );
				return $railModuleList;
			}
		}

		// Content, category and forum namespaces.  FB:1280 Added file,video,mw,template
		if ( $this->wg->Title->isSubpage() && $this->wg->Title->getNamespace() == NS_USER ||
			in_array( $subjectNamespace, [ NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM, NS_PROJECT, NS_FILE, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP ] ) ||
			in_array( $subjectNamespace, $this->wg->ContentNamespaces ) ||
			array_key_exists( $subjectNamespace, $this->wg->ExtraNamespaces )
		) {
			// add any content page related rail modules here

			$railModuleList[$latestActivityKey] = [ 'LatestActivity', 'Index', null ];
			$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

			if ( empty( $this->wg->EnableWikiAnswers ) ) {
				if ( $this->wg->EnableHuluVideoPanel ) {
					$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
				}
			}
		}

		// User page namespaces
		if ( in_array( $this->wg->Title->getNamespace(), self::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName( $this->wg->Title->getText() );

			if ( $page_owner ) {
				if ( !$page_owner->getGlobalPreference( 'hidefollowedpages' ) ) {
					$railModuleList[1101] = [ 'FollowedPages', 'Index', null ];
				}

				if ( $this->wg->EnableAchievementsExt ) {
					$railModuleList[1102] = [ 'Achievements', 'Index', null ];
				}
			}
		}

		if ( self::isBlogPost() || self::isBlogListing() ) {
			$railModuleList[1250] = [ 'PopularBlogPosts', 'Index', null ];
		}

		//  No rail on main page or edit page for oasis skin
		// except &action=history of wall
		if ( !empty( $this->wg->EnableWallEngine ) ) {
			$isEditPage = !WallHelper::isWallNamespace( $namespace ) && BodyController::isEditPage() || $this->wg->Request->getVal( 'diff' );
		} else {
			$isEditPage = BodyController::isEditPage();
		}

		if ( $isEditPage || WikiaPageType::isMainPage() ) {
			$modules = [ ];
			wfRunHooks( 'GetEditPageRailModuleList', [ &$modules ] );
			return $modules;
		}
		// No modules on Custom namespaces, unless they are in the ContentNamespaces list, those get the content rail
		if ( is_array( $this->wg->ExtraNamespacesLocal ) && array_key_exists( $subjectNamespace, $this->wg->ExtraNamespacesLocal ) && !in_array( $subjectNamespace, $this->wg->ContentNamespaces ) ) {
			return [ ];
		}
		// If the entire page is non readable due to permissions, don't display the rail either RT#75600
		if ( !$this->wg->Title->userCan( 'read' ) ) {
			return [ ];
		}

		$railModuleList[1440] = [ 'Ad', 'Index', [ 'slotName' => 'TOP_RIGHT_BOXAD' ] ];
		$railModuleList[1435] = [ 'AdEmptyContainer', 'Index', [ 'slotName' => 'NATIVE_TABOOLA_RAIL' ] ];
		$railModuleList[1100] = [ 'Ad', 'Index', [ 'slotName' => 'LEFT_SKYSCRAPER_2' ] ];

		unset( $railModuleList[1450] );

		wfRunHooks( 'GetRailModuleList', [ &$railModuleList ] );

		return $railModuleList;
	}


	public function executeIndex() {
		// set up global vars
		if ( is_array( $this->wg->MaximizeArticleAreaArticleIds )
			&& in_array( $this->wg->Title->getArticleID(), $this->wg->MaximizeArticleAreaArticleIds )
		) {
			$this->wg->SuppressRail = true;
			$this->wg->SuppressPageHeader = true;
		}

		// Replaces ContentDisplayModule->index()
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];

		$this->railModuleList = $this->getRailModuleList();
		// this hook allows adding extra HTML just after <body> opening tag
		// append your content to $html variable instead of echoing
		// (taken from Monaco skin)
		$skin = RequestContext::getMain()->getSkin();

		$afterBodyHtml = '';
		wfRunHooks( 'GetHTMLAfterBody', [ $skin, &$afterBodyHtml ] );
		$this->afterBodyHtml = $afterBodyHtml;

		$beforeWikiaPageHtml = '';
		wfRunHooks( 'GetHTMLBeforeWikiaPage', [ &$beforeWikiaPageHtml ] );
		$this->beforeWikiaPageHtml = $beforeWikiaPageHtml;


		// this hook is needed for SMW's factbox
		$afterContentHookText = '';
		wfRunHooks( 'SkinAfterContent', [ &$afterContentHookText ] );
		$this->afterContentHookText = $afterContentHookText;

		$this->headerModuleAction = 'Index';
		$this->headerModuleParams = [ 'showSearchBox' => false ];

		// show user pages header on this page?
		if ( self::showUserPagesHeader() ) {
			$this->headerModuleName = 'UserPagesHeader';
			// is this page a blog post?
			if ( self::isBlogPost() ) {
				$this->headerModuleAction = 'BlogPost';
			} // is this page a blog listing?
			else if ( self::isBlogListing() ) {
				$this->headerModuleAction = 'BlogListing';
			}
			// show corporate header on this page?
		} else if ( WikiaPageType::isCorporatePage() || WikiaPageType::isWikiaHub() ) {
			$this->headerModuleName = 'PageHeader';

			if ( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			} else {
				$this->headerModuleAction = 'Corporate';
			}

			if ( WikiaPageType::isWikiaHubMain() ) {
				$this->headerModuleAction = 'Hubs';
			}
		} else {
			$this->headerModuleName = 'PageHeader';
			if ( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			}
		}

		// Display Control Center Header on certain special pages
		if ( !empty( $this->wg->EnableAdminDashboardExt ) && AdminDashboardLogic::displayAdminDashboard( $this->app, $this->wg->Title ) ) {
			$this->headerModuleName = null;
			$this->displayAdminDashboard = true;
			$this->displayAdminDashboardChromedArticle = ( $this->wg->Title->getText() != SpecialPage::getTitleFor( 'AdminDashboard' )->getText() );
		} else {
			$this->displayAdminDashboard = false;
			$this->displayAdminDashboardChromedArticle = false;
		}

		$this->railModulesExist = true;

		// use one column layout for pages with no right rail modules
		if ( count( $this->railModuleList ) == 0 || !empty( $this->wg->SuppressRail ) ) {
			// Special:AdminDashboard doesn't need this class, but pages chromed with it do
			if ( !$this->displayAdminDashboard || $this->displayAdminDashboardChromedArticle ) {
				OasisController::addBodyClass( 'oasis-one-column' );
			}

			$this->headerModuleParams = [ 'showSearchBox' => true ];
			$this->railModulesExist = false;
		}

		// determine if WikiaGridLayout needs to be enabled
		$this->isGridLayoutEnabled = self::isGridLayoutEnabled();
		if ( $this->isGridLayoutEnabled ) {
			OasisController::addBodyClass( 'wikia-grid' );
		}

		if ( $this->isOasisBreakpoints() ) {
			OasisController::addBodyClass( 'oasis-breakpoints' );
		}

		//@TODO remove this check after deprecating responsive (July 2015)
		if ( $this->isResponsiveLayoutEnabled() ) {
			OasisController::addBodyClass( 'oasis-responsive' );
		}

		// if we are on a special search page, pull in the css file and don't render a header
		if ( $this->wg->Title && $this->wg->Title->isSpecial( 'Search' ) && !$this->wg->WikiaSearchIsDefault ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "skins/oasis/css/modules/SpecialSearch.scss" ) );
			$this->headerModuleName = null;
		}

		// Inter-wiki search
		if ( $this->wg->Title && ( $this->wg->Title->isSpecial( 'WikiaSearch' ) || ( $this->wg->Title->isSpecial( 'Search' ) && $this->wg->WikiaSearchIsDefault ) ) ) {
			$this->headerModuleName = null;
		}

		// load CSS for Special:Preferences
		if ( !empty( $this->wg->Title ) && $this->wg->Title->isSpecial( 'Preferences' ) ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialPreferences.scss' ) );
		}

		// load CSS for Special:Upload
		if ( !empty( $this->wg->Title ) && $this->wg->Title->isSpecial( 'Upload' ) ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialUpload.scss' ) );
		}

		// load CSS for Special:MultipleUpload
		if ( !empty( $this->wg->Title ) && $this->wg->Title->isSpecial( 'MultipleUpload' ) ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialMultipleUpload.scss' ) );
		}

		// load CSS for Special:Allpages
		if ( !empty( $this->wg->Title ) && $this->wg->Title->isSpecial( 'Allpages' ) ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialAllpages.scss' ) );
		}

		// VOLDEV-125: Fix Special:AllMessages colors on dark wikis
		if ( !empty( $this->wg->Title ) && $this->wg->Title->isSpecial( 'Allmessages' ) && SassUtil::isThemeDark() ) {
			$this->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialAllMessages.scss' ) );
		}

		// Forum Extension
		if ( !empty( $this->wg->EnableForumExt ) && ForumHelper::isForum() ) {
			$this->wg->SuppressPageHeader = true;
		}

		// MonetizationModule Extension
		if ( !empty( $this->wg->EnableMonetizationModuleExt ) ) {
			if ( empty( $this->wg->AdDriverUseMonetizationService ) ) {
				$this->monetizationModules = $this->sendRequest( 'MonetizationModule', 'index' )->getData()['data'];
				$this->headerModuleParams['monetizationModules'] = $this->monetizationModules;
			} else {
				$this->monetizationModules = [
					MonetizationModuleHelper::SLOT_TYPE_IN_CONTENT     => $this->app->renderView( 'Ad', 'Index', [ 'slotName' => 'MON_IN_CONTENT' ] ),
					MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY => $this->app->renderView( 'Ad', 'Index', [ 'slotName' => 'MON_BELOW_CATEGORY' ] ),
				];
			}
			$this->bodytext = MonetizationModuleHelper::insertIncontentUnit( $this->bodytext, $this->monetizationModules );
		}

		$namespace = $this->wg->Title->getNamespace();
		// extra logic for subpages (RT #74091)
		if ( !empty( $this->subtitle ) ) {
			switch ( $namespace ) {
				// for user subpages add link to theirs talk pages
				case NS_USER:
					$talkPage = $this->wg->Title->getTalkPage();

					// get number of revisions for talk page
					$service = new PageStatsService( $this->wg->Title->getArticleID() );
					$comments = $service->getCommentsCount();

					// render comments bubble
					$bubble = $this->app->renderView( 'CommentsLikes', 'Index', [ 'comments' => $comments, 'bubble' => true ] );

					$this->subtitle .= ' | ';
					$this->subtitle .= $bubble;
					$this->subtitle .= Wikia::link( $talkPage );
					break;

				case NS_USER_TALK:
					$subjectPage = $this->wg->Title->getSubjectPage();

					$this->subtitle .= ' | ';
					$this->subtitle .= Wikia::link( $subjectPage );
					break;
			}
		}

		// bugid-70243: optionally hide navigation h1s for SEO
		$this->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );
	}
}
