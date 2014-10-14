<?php
class ContentController extends WikiaController {

	public function init() {
		$this->subtitle = $this->app->getSkinTemplateObj()->data['subtitle'];
	}

	public function executeIndex($errors) {
		global $wgTitle;

		// Replaces ContentDisplayModule->index()
		$this->bodytext = $this->app->getSkinTemplateObj()->data['bodytext'];

		// Double-click to edit
		$this->body_ondblclick = ''; // FIXME handling moved to OutputPage::addDefaultModules()

		$this->railModuleList = $this->getRailModuleList();
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

		$latestPhotosKey = $wgUser->isAnon() ? 1300 : 1250;
		$latestActivityKey = $wgUser->isAnon() ? 1250 : 1300;
		$huluVideoPanelKey = $wgUser->isAnon() ? 1390 : 1280;

		// Forum Extension
		if ($wgEnableForumExt && ForumHelper::isForum()) {
			$railModuleList = array (
				1500 => array('Search', 'Index', null),
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
						$railModuleList[$latestPhotosKey] = array('LatestPhotos', 'Index', null);
						if ($wgEnableHuluVideoPanel) {
							$railModuleList[$huluVideoPanelKey] = array('HuluVideoPanel', 'Index', null);
						}
					}
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
		} else if ( !BodyController::showUserPagesHeader() ) {
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
		if( in_array($wgTitle->getNamespace(), BodyController::getUserPagesNamespaces() ) ) {
			$page_owner = User::newFromName($wgTitle->getText());

			if($page_owner) {
				if ( !$page_owner->getOption('hidefollowedpages') ) {
					$railModuleList[1101] = array('FollowedPages', 'Index', null);
				}

				if ( $wgEnableAchievementsExt ) {
					$railModuleList[1102] = array('Achievements', 'Index', null);
				}
			}
		}

		if (BodyController::isBlogPost() || BodyController::isBlogListing()) {
			$railModuleList[1500] = array('Search', 'Index', null);
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
		$railModuleList[1291] = array('Ad', 'Index', ['slotName' => 'MIDDLE_RIGHT_BOXAD']);
		$railModuleList[1100] = array('Ad', 'Index', ['slotName' => 'LEFT_SKYSCRAPER_2']);

		unset($railModuleList[1450]);

		wfRunHooks( 'GetRailModuleList', array( &$railModuleList ) );

		wfProfileOut(__METHOD__);

		return $railModuleList;
	}
}