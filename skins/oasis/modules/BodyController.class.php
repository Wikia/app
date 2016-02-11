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
	 *
	 * @param $editPage
	 * @return bool true
	 */
	public static function onEditPageRender( &$editPage ) {
		self::$onEditPage = true;
		return true;
	}

	/**
	 * Detect we're on edit (or diff) page
	 *
	 * @return bool
	 */
	public static function isEditPage() {
		$app = F::app();

		return (
			!empty( self::$onEditPage ) ||
			// diff pages - RT #69931
			!is_null( $app->wg->Request->getVal( 'diff' ) ) ||
			in_array(
				$app->wg->Request->getVal( 'action', 'view' ), [
					'edit',		// view source page
					'formedit',	// SMW edit pages
					'history',	// history pages
					'submit',	// conflicts, etc.
				]
			)
		);
	}

	/**
	 * Check whether current page is blog post
	 *
	 * @return bool
	 */
	public static function isBlogPost() {
		$app = F::app();

		return (
			defined( 'NS_BLOG_ARTICLE' ) &&
			$app->wg->Title->getNamespace() == NS_BLOG_ARTICLE &&
			$app->wg->Title->isSubpage()
		);
	}

	/**
	 * Check whether current page is blog listing
	 *
	 * @return bool
	 */
	public static function isBlogListing() {
		$app = F::app();

		return (
			defined( 'NS_BLOG_LISTING' ) &&
			$app->wg->Title->getNamespace() == NS_BLOG_LISTING
		);
	}

	/**
	 * Returns if current layout should be applying gridlayout
	 *
	 * @return bool
	 */
	public static function isGridLayoutEnabled() {
		if ( self::isOasisBreakpoints() ) {
			return false;
		}

		$app = F::app();

		// Don't enable when responsive layout is enabled
		if ( self::isResponsiveLayoutEnabled() ) {
			return false;
		}

		if ( !empty( $app->wg->OasisGrid ) ) {
			return true;
		}

		$ns = $app->wg->Title->getNamespace();

		if ( in_array( MWNamespace::getSubject( $ns ), $app->wg->WallNS ) ) {
			return true;
		}

		if (
			defined( 'NS_WIKIA_FORUM_TOPIC_BOARD' ) &&
			$ns == NS_WIKIA_FORUM_TOPIC_BOARD
		) {
			return true;
		}

		return false;
	}

	/**
	 * Decide whether Oasisbreakpoints should be enabled.
	 *
	 * @return bool
	 */
	public static function isOasisBreakpoints() {
		$app = F::app();
		$app->wg->OasisBreakpoints = $app->wg->Request->getBool( 'oasisbreakpoints', $app->wg->OasisBreakpoints ) !== false;

		return !empty( $app->wg->OasisBreakpoints );
	}

	/**
	 * Decide on which pages responsive/liquid layout should be turned on.
	 *
	 * @return bool
	 */
	public static function isResponsiveLayoutEnabled() {
		$app = F::app();

		return !self::isOasisBreakpoints() && !empty( $app->wg->OasisResponsive );
	}

	/**
	 * Decide whether OasisTypography should be enabled
	 *
	 * @return bool
	 */
	public static function isOasisTypography() {
		$app = F::app();

		$app->wg->OasisTypography = $app->wg->Request->getBool( 'oasistypography', $app->wg->OasisTypography ) !== false;
		return !empty( $app->wg->OasisTypography );
	}

	/**
	 * Decide whether to show user pages header on current page
	 *
	 * @return bool
	 */
	public static function showUserPagesHeader() {
		$app = F::app();
		$wgTitle = $app->wg->Title;

		// perform namespace and special page check
		$isUserPage = in_array(
			$wgTitle->getNamespace(),
			self::getUserPagesNamespaces()
		);

		$ret = ( $isUserPage && !$wgTitle->isSubpage() ) ||
				$wgTitle->isSpecial( 'Following' ) ||
				$wgTitle->isSpecial( 'Contributions' ) ||
				$wgTitle->isSpecial( 'UserActivity' ) ||
				(
					defined( 'NS_BLOG_LISTING' ) &&
					$wgTitle->getNamespace() == NS_BLOG_LISTING
				) ||
				(
					defined( 'NS_BLOG_ARTICLE' ) &&
					$wgTitle->getNamespace() == NS_BLOG_ARTICLE
				);

		return $ret;
	}

	/**
	 * Return list of namespaces on which user pages header should be shown
	 *
	 * @return array $namespaces
	 */
	public static function getUserPagesNamespaces() {
		$app = F::app();
		$namespaces = [ NS_USER ];

		if ( empty( $app->wg->EnableWallExt ) ) {
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

	/**
	 * Get a list of rail modules
	 *
	 * @return array $railModuleList
	 */
	public function getRailModuleList() {
		$wg = $this->wg;

		$namespace = $wg->Title->getNamespace();
		$subjectNamespace = MWNamespace::getSubject($namespace);

		$railModuleList = [];

		$latestActivityKey = $wg->User->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $wg->User->isAnon() ? 1390 : 1280;

		// Forum Extension
		if ( $wg->EnableForumExt && ForumHelper::isForum() ) {
			$railModuleList[1202] = [ 'Forum', 'forumRelatedThreads', null ];
			$railModuleList[1201] = [ 'Forum', 'forumActivityModule', null ];
			$railModuleList[1490] = [ 'Ad', 'Index', [ 'slotName' => 'TOP_RIGHT_BOXAD' ] ];

			// Include additional modules from other extensions (like chat)
			wfRunHooks( 'GetRailModuleList', [ &$railModuleList ] );

			return $railModuleList;
		}

		if ( $namespace == NS_SPECIAL ) {
			if ( WikiaPageType::isSearch() ) {
				if ( empty( $wg->EnableWikiaHomePageExt ) ) {
					$railModuleList[$latestActivityKey] = [ 'LatestActivity', 'Index', null ];
					$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

					if ( empty( $wg->EnableWikiAnswers ) ) {
						if ( $wg->EnableHuluVideoPanel ) {
							$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
						}
					}
				}
			} elseif ( $wg->Title->isSpecial( 'Leaderboard' ) ) {
				$railModuleList[$latestActivityKey] = [ 'LatestActivity', 'Index', null ];
				$railModuleList[1290] = [ 'LatestEarnedBadges', 'Index', null ];
			} elseif ( $wg->Title->isSpecial( 'WikiActivity' ) ) {
				$railModuleList[1102] = [ 'HotSpots', 'Index', null ];
				$railModuleList[1101] = [ 'CommunityCorner', 'Index', null ];
				$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];
			} elseif (
				$wg->Title->isSpecial( 'Following' ) ||
				$wg->Title->isSpecial( 'Contributions' )
			) {
				// intentionally nothing here
			} elseif ( $wg->Title->isSpecial( 'ThemeDesignerPreview' ) ) {
				$railModuleList[$latestActivityKey] = [ 'LatestActivity', 'Index', null ];
				$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

				if ( empty( $wg->EnableWikiAnswers ) ) {
					if ( $wg->EnableHuluVideoPanel ) {
						$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
					}
				}
			} else {
				// don't show any module for MW core special pages
				wfRunHooks( 'GetRailModuleSpecialPageList', [ &$railModuleList ] );
				return $railModuleList;
			}
		}

		// Content, category and forum namespaces.  FB:1280 Added file,video,mw,template
		if (
			$wg->Title->isSubpage() && $wg->Title->getNamespace() == NS_USER ||
			in_array( $subjectNamespace, [ NS_CATEGORY, NS_CATEGORY_TALK, NS_FORUM, NS_PROJECT, NS_FILE, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP ] ) ||
			in_array( $subjectNamespace, $wg->ContentNamespaces ) ||
			array_key_exists( $subjectNamespace, $wg->ExtraNamespaces )
		) {
			// add any content page related rail modules here
			$railModuleList[$latestActivityKey] = [ 'LatestActivity', 'Index', null ];
			$railModuleList[1450] = [ 'PagesOnWiki', 'Index', null ];

			if ( empty( $wg->EnableWikiAnswers ) ) {
				if ( $wg->EnableHuluVideoPanel ) {
					$railModuleList[$huluVideoPanelKey] = [ 'HuluVideoPanel', 'Index', null ];
				}
			}
		}

		// User page namespaces
		if ( in_array( $wg->Title->getNamespace(), self::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName( $wg->Title->getText() );

			if ( $page_owner ) {
				if ( !$page_owner->getGlobalPreference( 'hidefollowedpages' ) ) {
					$railModuleList[1101] = [ 'FollowedPages', 'Index', null ];
				}

				if ( $wg->EnableAchievementsExt ) {
					$railModuleList[1102] = [ 'Achievements', 'Index', null ];
				}
			}
		}

		if ( self::isBlogPost() || self::isBlogListing() ) {
			$railModuleList[1250] = [ 'PopularBlogPosts', 'Index', null ];
		}

		//  No rail on main page or edit page for oasis skin
		// except &action=history of wall
		if ( !empty( $wg->EnableWallEngine ) ) {
			$isEditPage = !WallHelper::isWallNamespace( $namespace ) && BodyController::isEditPage() || $wg->Request->getVal('diff');
		} else {
			$isEditPage = BodyController::isEditPage();
		}

		if ( $isEditPage || WikiaPageType::isMainPage() ) {
			$modules = [];
			wfRunHooks( 'GetEditPageRailModuleList', [ &$modules ] );
			wfProfileOut(__METHOD__);
			return $modules;
		}

		// No modules on Custom namespaces, unless they are in the ContentNamespaces list, those get the content rail
		if (
			is_array( $wg->ExtraNamespacesLocal ) &&
			array_key_exists( $subjectNamespace, $wg->ExtraNamespacesLocal ) &&
			!in_array( $subjectNamespace, $wg->ContentNamespaces )
		) {
			return [];
		}

		// If the entire page is non readable due to permissions
		// don't display the rail either RT#75600
		if ( !$wg->Title->userCan( 'read' ) ) {
			return [];
		}

		$railModuleList[1439] = [ 'Contribute', 'index', null ];
		$railModuleList[1440] = [ 'Ad', 'Index', [ 'slotName' => 'TOP_RIGHT_BOXAD' ] ];
		$railModuleList[1435] = [ 'AdEmptyContainer', 'Index', [ 'slotName' => 'NATIVE_TABOOLA_RAIL' ] ];
		$railModuleList[1100] = [ 'Ad', 'Index', [ 'slotName' => 'LEFT_SKYSCRAPER_2' ] ];

		unset( $railModuleList[1450] );

		wfRunHooks( 'GetRailModuleList', [ &$railModuleList ] );

		return $railModuleList;
	}

	/**
	 * Index method for Body template
	 */
	public function executeIndex() {
		$wg = $this->wg;

		// set up global vars
		if (
			is_array( $wg->MaximizeArticleAreaArticleIds ) &&
			in_array( $wg->Title->getArticleId(), $wg->MaximizeArticleAreaArticleIds )
		) {
			$wg->SuppressRail = true;
			$wg->SuppressPageHeader = true;
		}

		// Double-click to edit
		// FIXME handling moved to OutputPage::addDefaultModules()
		$this->body_ondblclick = '';

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

			// is this page a blog listing?
			} elseif ( self::isBlogListing() ) {
				$this->headerModuleAction = 'BlogListing';
			}

		// show corporate header on this page?
		} elseif ( WikiaPageType::isCorporatePage() || WikiaPageType::isWikiaHub() ) {
			$this->headerModuleName = 'PageHeader';

			if ( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			} else {
				$this->headerModuleAction = 'Corporate';
			}

			if ( WikiaPageType::isWikiaHubMain() ) {
				$this->headerModuleAction = 'Hubs';

			// FIXME: move to separate module
			} elseif ( WikiaPageType::isMainPage() ) {
				$wg->SuppressFooter = true;
				$wg->SuppressArticleCategories = true;
				$wg->SuppressPageHeader = true;
				$wg->SuppressWikiHeader = true;
				$wg->SuppressSlider = true;
			}
		} else {
			$this->headerModuleName = 'PageHeader';
			if ( self::isEditPage() ) {
				$this->headerModuleAction = 'EditPage';
			}
		}

		// Display Control Center Header on certain special pages
		if (
			!empty( $wg->EnableAdminDashboardExt ) &&
			AdminDashboardLogic::displayAdminDashboard( $this->app, $wg->Title )
		) {
			$this->headerModuleName = null;
			$this->wgSuppressAds = true;
			$this->displayAdminDashboard = true;
			$this->displayAdminDashboardChromedArticle = ( $wg->Title->getText() != SpecialPage::getTitleFor( 'AdminDashboard' )->getText() );
		} else {
			$this->displayAdminDashboard = false;
			$this->displayAdminDashboardChromedArticle = false;
		}

		$this->railModulesExist = true;

		// use one column layout for pages with no right rail modules
		if ( count( $this->railModuleList ) == 0 || !empty( $wg->SuppressRail ) ) {
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
		if (
			$wg->Title &&
			$wg->Title->isSpecial( 'Search' ) &&
			!$wg->WikiaSearchIsDefault
		) {
			$wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialSearch.scss' ) );
			$this->headerModuleName = null;
		}

		// Inter-wiki search
		if (
			$wg->Title &&
			(
				$wg->Title->isSpecial( 'WikiaSearch' ) ||
				( $wg->Title->isSpecial( 'Search' ) && $wg->WikiaSearchIsDefault )
			)
		) {
			$this->headerModuleName = null;
		}

		// load CSS for Special:Preferences
		if ( !empty( $wg->Title ) && $wg->Title->isSpecial( 'Preferences' ) ) {
			$wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialPreferences.scss'));
		}

		// load CSS for Special:Upload
		if ( !empty( $wg->Title ) && $wg->Title->isSpecial( 'Upload' ) ) {
			$wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('skins/oasis/css/modules/SpecialUpload.scss' ) );
		}

		// load CSS for Special:MultipleUpload
		if ( !empty( $wg->Title ) && $wg->Title->isSpecial( 'MultipleUpload' ) ) {
			$wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialMultipleUpload.scss' ) );
		}

		// load CSS for Special:Allpages
		if ( !empty( $wg->Title ) && $wg->Title->isSpecial( 'Allpages' ) ) {
			$wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'skins/oasis/css/modules/SpecialAllpages.scss' ) );
		}

		// Forum Extension
		if ( !empty( $wg->EnableForumExt ) && ForumHelper::isForum() ) {
			$wg->SuppressPageHeader = true;
		}

		// MonetizationModule Extension
		if ( !empty( $wg->EnableMonetizationModuleExt ) ) {
			if ( empty( $wg->AdDriverUseMonetizationService ) ) {
				$this->monetizationModules = $this->sendRequest( 'MonetizationModule', 'index' )->getData()['data'];
				$this->headerModuleParams['monetizationModules'] = $this->monetizationModules;
			} else {
				$this->monetizationModules = [
					MonetizationModuleHelper::SLOT_TYPE_IN_CONTENT => $this->app->renderView(
						'Ad',
						'Index',
						[ 'slotName' => 'MON_IN_CONTENT' ]
					),
					MonetizationModuleHelper::SLOT_TYPE_BELOW_CATEGORY => $this->app->renderView(
						'Ad',
						'Index',
						[ 'slotName' => 'MON_BELOW_CATEGORY' ]
					),
				];
			}
			$this->bodytext = MonetizationModuleHelper::insertIncontentUnit( $this->bodytext, $this->monetizationModules );
		}

		$namespace = $wg->Title->getNamespace();
		// extra logic for subpages (RT #74091)
		if ( !empty( $this->subtitle ) ) {
			switch ( $namespace ) {
				// for user subpages add link to their talk pages
				case NS_USER:
					$talkPage = $wg->Title->getTalkPage();

					// get number of revisions for talk page
					$service = new PageStatsService( $wg->Title->getArticleId() );
					$comments = $service->getCommentsCount();

					// render comments bubble
					$bubble = $this->app->renderView(
						'CommentsLikes',
						'Index',
						[ 'comments' => $comments, 'bubble' => true ]
					);

					$this->subtitle .= ' | ';
					$this->subtitle .= $bubble;
					$this->subtitle .= Wikia::link( $talkPage );
					break;

				case NS_USER_TALK:
					$subjectPage = $wg->Title->getSubjectPage();

					$this->subtitle .= ' | ';
					$this->subtitle .= Wikia::link( $subjectPage );
					break;
			}
		}

		// bugid-70243: optionally hide navigation h1s for SEO
		$this->displayHeader = !$wg->HideNavigationHeaders;
	}
}
