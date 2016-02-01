<?php
use Wikia\Logger\WikiaLogger;

/**
 * Renders page header (title, subtitle, comments chicklet button, history dropdown)
 *
 * @author Maciej Brencz
 */

class PageHeaderController extends WikiaController {
	/**
	 * @var SkinTemplate
	 */
	private $skinTemplate;

	/**
	 * @var skinVars
	 */
	private $skinVars;

	public function init() {
		$this->skinTemplate = $this->app->getSkinTemplateObj();
		$this->skinVars = $this->skinTemplate->data;
	}

	/**
	 * Use MW core variable to generate action button
	 *
	 * @return array $button
	 */
	protected function prepareActionButton() {
		$wg = $this->wg;
		$button = [];
		$actions = $this->skinVars['content_actions'];
		$isDiff = !is_null( $wg->Request->getVal( 'diff' ) );

		// remove "Add topic" action on diff pages (RT #72666)
		if ( isset( $actions['addsection'] ) && $isDiff ) {
			unset( $actions['addsection'] );
		}

		// handle protected pages (they should have viewsource link and lock icon)
		// BugId:9494
		if (
			isset( $actions['viewsource'] ) &&
			!$wg->Title->isProtected() &&
			!$wg->Title->isNamespaceProtected( $wg->User ) &&
			// VOLDEV-74: logged in users should see the viewsource button, not edit
			!$wg->User->isLoggedIn()
		) {
			// force login to edit page that is not protected
			$actions['edit'] = $actions['viewsource'];
			$actions['edit']['text'] = wfMessage( 'edit' )->escaped();
			unset( $actions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $actions['edit'] ) && $wg->Title->isCascadeProtected() ) {
			$actions['viewsource'] = $actions['edit'];
			$actions['viewsource']['text'] = wfMessage( 'viewsource' )->escaped();
			unset( $actions['edit'] );
		}

		// PvX's rate (RT #76386)
		// @todo does this even work? couldn't find it in production
		//       the wiki is forked and the extensions are unmaintained anyway
		if ( isset( $actions['rate'] ) ) {
			$button['action'] = $actions['rate'];
			$button['name'] = 'rate';
		}
		// "Add topic"
		elseif ( isset( $actions['addsection'] ) ) {
			$button['action'] = $actions['addsection'];
			$button['action']['text'] = wfMessage( 'oasis-page-header-add-topic' )->escaped();
			$button['image'] = MenuButtonController::ADD_ICON;
			$button['name'] = 'addtopic';
		}
		// "Edit with form" (SMW)
		elseif ( isset( $actions['form_edit'] ) ) {
			$button['action'] = $actions['form_edit'];
			$button['image'] = MenuButtonController::EDIT_ICON;
			$button['name'] = 'form-edit';
		}
		// ve-edit
		elseif ( isset( $actions['ve-edit'] ) && $actions['ve-edit']['main'] ) {
			$button['action'] = $actions['ve-edit'];
			$button['image'] = MenuButtonController::EDIT_ICON;
			$button['name'] = 've-edit';
			unset( $actions['ve-edit'] );
		}
		// edit
		elseif ( isset( $actions['edit'] ) ) {
			$button['action'] = $actions['edit'];
			$button['image'] = MenuButtonController::EDIT_ICON;
			$button['name'] = 'edit';
			unset( $actions['edit'] );
		}
		// view source
		elseif ( isset( $actions['viewsource'] ) ) {
			$button['action'] = $actions['viewsource'];
			$button['image'] = MenuButtonController::LOCK_ICON;
			$button['name'] = 'source';
			unset( $actions['ve-edit'], $actions['edit'] );
		}

		$button['dropdown'] = $this->getDropdownActions( $actions );
		return $button;
	}

	/**
	 * Get content actions for dropdown
	 *
	 * @param array $actions
	 * @return array $ret
	 */
	protected function getDropdownActions( $actions ) {
		$ret = [];
		$editActions = [];

		if ( isset( $actions['edit'] ) ) {
			array_push( $editActions, 'edit' );
		}

		if ( isset( $actions['ve-edit'] ) ) {
			if ( $actions['ve-edit']['main'] ) {
				array_unshift( $editActions, 've-edit' );
			} else {
				array_push( $editActions, 've-edit' );
			}
		}

		// items to be added to "edit" dropdown
		$dropdownActions = array_merge(
			$editActions,
			['history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file']
		);

		// Enable to modify actions list on dropdown
		wfRunHooks( 'PageHeaderDropdownActions', [ &$dropdownActions ] );

		foreach ( $dropdownActions as $action ) {
			if ( isset( $actions[$action] ) ) {
				$ret[$action] = $actions[$action];
			}
		}

		return $ret;
	}

	private function getCuratedContentButton() {
		if ( !empty( $this->wg->EnableCuratedContentExt ) ) {
			return $this->app->sendRequest( 'CuratedContent', 'editButton' );
		} else {
			return null;
		}
	}

	/**
	 * Get the page title
	 * Used by executeIndex and executeCorporate
	 *
	 * @return string $title
	 */
	private function getTitle( $mainpageTitle = null ) {
		$displayTitle = true;
		$wg = $this->wg;
		$ns = $wg->Title->getNamespace();
		$removeNamespacePrefix = array_merge(
			[ NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE, NS_FORUM ],
			$wg->SuppressNamespacePrefix,
			// varies depending on what extensions are installed
			// so use this instead
			BodyController::getUserPagesNamespaces()
		);

		// special pages
		if ( $ns === NS_SPECIAL ) {
			$title = $this->skinVars['title'];

		// wrap talk page ns in strong tags
		} elseif ( $wg->Title->isTalkPage() ) {
			$title = Xml::element( 'strong', [], $wg->ContLang->getNsText( NS_TALK ) . ':' );
			$title .= htmlspecialchars( $wg->Title->getText() );

		// remove prefixes from certain namespaces
		// needs to be after the above so it doesn't affect NS_USER_TALK
		// see BodyController::getUserPagesNamespaces
		} elseif ( in_array( $ns, $removeNamespacePrefix ) ) {
			$title = $wg->Title->getText();
			$displayTitle = false;

		// use message for mainpage title unless it needs to be overridden
		} elseif ( WikiaPageType::isMainPage() ) {
			$title = $mainpageTitle !== null
				? $mainpageTitle
				: wfMessage( 'oasis-home' )->escaped();

		// and everything else
		} else {
			$title = $wg->Out->getPageTitle();
		}

		// escape the title if it's not handed elsewhere already
		if ( $displayTitle === false ) {
			$title = htmlspecialchars( $title );
		}

		return $title;
	}

	/**
	 * Render default page header (with edit dropdown, history dropdown, ...)
	 *
	 * @param array $params
	 */
	public function executeIndex( $params ) {
		$wg = $this->wg;
		$isMainPage = WikiaPageType::isMainPage();
		$ns = $wg->Title->getNamespace();
		$skin = RequestContext::getMain()->getSkin();

		$this->runNjord = ( !empty( $wg->EnableNjordExt ) && $isMainPage );
		// this only happens on archived talk pages, which are subpages of NS_USER_WALL
		// however the history of those pages are in NS_USER_TALK
		$this->isWallEnabled = ( !empty( $wg->EnableWallExt ) && $ns == NS_USER_WALL );
		$this->isSpecialVideos = $wg->Title->isSpecial( 'Videos' );

		// get main edit button and dropdown
		$this->button = $this->prepareActionButton();
		// allow other extensions to modify the main button and/or dropdown
		wfRunHooks( 'PageHeaderIndexAfterActionButtonPrepared', [ &$this->button ] );

		$this->curatedContentToolButton = $this->getCuratedContentButton();

		// comments button (for talk page)
		if ( !$this->isWallEnabled &&
			( $wg->Title->isTalkPage() || in_array( $ns, [ NS_FORUM, NS_SPECIAL ] ) )
		) {
			$this->comments = false;
		} else {
			$service = PageStatsService::newFromTitle( $wg->Title );
			$this->comments = $service->getCommentsCount();
		}

		// allow other extensions to append extra buttons to the header
		$this->extraButtons = [];
		wfRunHooks( 'PageHeaderIndexExtraButtons', [ &$this->extraButtons ] );

		// get the page title
		$this->title = $this->getTitle();

		// back to subject article link for talk pages
		if ( $wg->Title->isTalkPage() ) {
			
			switch( $ns ) {
				case NS_TEMPLATE_TALK:
					$msgKey = 'oasis-page-header-back-to-template';
					break;

				case NS_MEDIAWIKI_TALK:
					$msgKey = 'oasis-page-header-back-to-mediawiki';
					break;

				case NS_CATEGORY_TALK:
					$msgKey = 'oasis-page-header-back-to-category';
					break;

				case NS_FILE_TALK:
					$msgKey = 'oasis-page-header-back-to-file';
					break;

				default:
					$msgKey = 'oasis-page-header-back-to-article';
			}

			$this->pageTalkSubject = Wikia::link(
				$wg->Title->getSubjectPage(),
				wfMessage( $msgKey )->escaped(),
				['accesskey' => 'c']
			);
		}

		// render page type info
		switch( $ns ) {
			case NS_MEDIAWIKI:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-mediawiki' )->escaped();
				break;

			case NS_TEMPLATE:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-template' )->escaped();
				break;

			case NS_SPECIAL:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-special' )->escaped();

				if ( $wg->Title->isSpecial( 'Videos' ) ) {
					$this->isSpecialVideos = true;
					$mediaService = ( new MediaQueryService );
					$this->tallyMsg = wfMessage( 'specialvideos-wiki-videos-tally', $mediaService->getTotalVideos() )->parse();
				}

				break;

			case NS_CATEGORY:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-category' )->escaped();
				break;

			case NS_FORUM:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-forum' )->escaped();
				break;
		}
		wfRunHooks( 'PageHeaderPageTypePrepared', [ $this, $this->getContext()->getTitle() ] );

		// render subpage info
		$this->pageSubject = $skin->subPageSubtitle();

		// render MW subtitle (contains old revision data)
		$this->subtitle = $wg->Out->getSubtitle();

		// render redirect info (redirected from)
		if ( !empty( $wg->Article->mRedirectedFrom ) ) {
			$this->pageRedirect = trim( $this->subtitle, '()' );
			$this->subtitle = '';
		}

		// set "redirect page" subtitle here
		// this is suppressed in oasis so it can be rebuilt as part of the breadcrumbs
		// @see Article::view
		if ( $wg->Title->isRedirect() ) {
			$this->pageType = wfMessage( 'redirectpagesub' )->escaped();
		}

		if ( !empty( $wg->SupressPageTitle ) ) {
			$this->title = '';
			$this->subtitle = '';
		}

		if ( !empty( $wg->SupressPageSubtitle ) ) {
			$this->subtitle = '';
			$this->pageSubtitle = '';
		} else {
			// render pageType, pageSubject and pageSubtitle as one message
			$pageSubtitle = array_filter( [
				$this->pageType,
				$this->pageTalkSubject,
				$this->pageSubject,
				$this->pageRedirect,
			] );

			/*
			 * support for language variants
			 * this adds links which automatically convert the content to that variant
			 *
			 * @author tor@wikia-inc.com
			 * @author macbre@wikia-inc.com
			 */
			$variants = $this->skinTemplate->get( 'content_navigation' )['variants'];

			if ( !empty( $variants ) ) {
				foreach ( $variants as $variant ) {
					$pageSubtitle[] = Xml::element(
						'a',
						[
							'href' => $variant['href'],
							'rel' => 'nofollow',
							'id' => $variant['id']
						],
						$variant['text']
					);
				}
			}

			$pipe = wfMessage( 'pipe-separator' )->escaped();
			$this->pageSubtitle = implode( " {$pipe} ", $pageSubtitle );
		}

		// render monetization module
		if ( !empty( $params['monetizationModules'] ) ) {
			$this->monModules = $params['monetizationModules'];
		}
	}

	/**
	 * Render header for edit page
	 *
	 * Used on:
	 * - ?action=history
	 * - diffs
	 * - ?action=formedit (SMW)
	 * - ?action=edit (only when $wgReadOnly is set)
	 */
	public function executeEditPage() {
		$wg = $this->wg;
		$ns = $wg->Title->getNamespace();

		// special handling for special pages (CreateBlogPost, CreatePage)
		if ( $ns == NS_SPECIAL ) {
			return;
		}

		$action = $wg->Request->getVal( 'action', 'view' );
		$subtitle = [];

		// detect usage
		// a few of these are very rarely true if ever
		// @example isEdit, isSectionEdit, isShowChanges, isPreview
		$isPreview = $wg->Request->getCheck( 'wpPreview' ) || $wg->Request->getCheck( 'wpLivePreview' );
		$isSectionEdit = is_numeric( $wg->Request->getVal( 'section' ) );
		$isEdit = in_array( $action, ['edit', 'submit'] );
		$isShowChanges = $wg->Request->getCheck( 'wpDiff' );
		$isDiff = !is_null( $wg->Request->getVal( 'diff' ) ); // RT #69931
		$isHistory = $action == 'history';

		$this->isHistory = $isHistory;
		$this->isUserTalkArchiveModeEnabled = (
			!empty( $wg->EnableWallExt ) &&
			$ns == NS_USER_TALK
		);

		// add editor's right rail when not editing main page
		if ( !Wikia::isMainPage() ) {
			OasisController::addBodyClass( 'editor-rail' );
		}

		// hide floating toolbar when on edit page / in preview mode / show changes
		if (
			$isEdit ||
			$isPreview ||
			$isDiff ||
			( $isHistory && !$this->isUserTalkArchiveModeEnabled )
		) {
			// show only "My Tools" dropdown on toolbar
			$wg->SuppressToolbar = true;
		}

		// choose header message
		if ( $isPreview ) {
			$titleMsg = 'oasis-page-header-preview';
		} elseif ( $isShowChanges ) {
			$titleMsg = 'oasis-page-header-changes';
		} elseif ( $isDiff ) {
			$titleMsg = 'oasis-page-header-diff';
		} elseif ( $isSectionEdit ) {
			$titleMsg = 'oasis-page-header-editing-section';
		} elseif ( $isHistory ) {
			$titleMsg = 'oasis-page-header-history';
		} else {
			$titleMsg = 'oasis-page-header-editing';
		}

		$this->title = wfMessage( $titleMsg, $wg->Title->getPrefixedText() )->parse();

		// back to article link
		if ( !$isPreview && !$isShowChanges ) {
			$subtitle[] = Wikia::link(
				$wg->Title,
				wfMessage( 'oasis-page-header-back-to-article' )->escaped(),
				['accesskey' => 'c'],
				[],
				'known'
			);
		}

		// add edit button
		if ( $isDiff || ( $isHistory && !$this->isUserTalkArchiveModeEnabled ) ) {
			$this->button = $this->prepareActionButton();
		}

		if ( $isHistory ) {
			// FB#1137 - re-add missing log and undelete links
			$logPage = SpecialPage::getTitleFor( 'Log' );
			$subtitle[] = Wikia::link(
				$logPage,
				wfMessage( 'viewpagelogs' )->escaped(),
				[],
				[ 'page' => $wg->Title->getPrefixedText() ],
				[ 'known', 'noclasses' ]
			);

			// FIXME: Skin is now an abstract class (MW1.19)
			// (wladek) created non-abstract FakeSkin class, is it the correct solution?
			$sk = new FakeSkin();
			$sk->setRelevantTitle( $wg->Title );

			$undeleteLink = $sk->getUndeleteLink();

			if ( !empty( $undeleteLink ) ) {
				$subtitle[] = $undeleteLink;
			}

			// comments button (for talk page)
			$service = new PageStatsService( $wg->Title->getArticleId() );
			$this->comments = $service->getCommentsCount();
		}

		// allows extensions to modify any part of the set output
		// in practice, it should be limited to:
		// - changing the action button and dropdown
		// - changing the title
		// - changing the subtitle
		// - suppressing/adding the talk page button
		wfRunHooks( 'PageHeaderEditPage', [ &$this, $ns, $isPreview, $isShowChanges, $isDiff, $isEdit, $isHistory ] );

		$pipe = wfMessage( 'pipe-separator' )->escaped();
		$this->subtitle = implode( " {$pipe} ", $subtitle );
	}

	/**
	 * Called instead of executeIndex when the CorporatePage extension is enabled.
	 */
	public function executeCorporate() {
		$wg = $this->wg;

		$this->canAct = $wg->User->isAllowed( 'edit' );

		if ( $this->canAct ) {
			$this->button = $this->prepareActionButton();
		}

		$this->title = $this->getTitle( /* $mainpageTitle = */ '' );
		$this->subtitle = $this->skinVars['subtitle'];

		if ( WikiaPageType::isMainPage() ) {
			$this->subtitle = '';
		}
	}

	/**
	 * Render page header for Hubs
	 *
	 * @param: array $params
	 */
	public function executeHubs( $params ) {
		$wg = $this->wg;

		// Leave this for now. To discuss do we want PageTitle
		$this->title = wfMessage( 'oasis-home' )->escaped();

		if ( !empty( $wg->SupressPageTitle ) ) {
			$this->title = '';
		}

		// temp styles loader for testing
		$this->response->addAsset( 'wikiahubs_v3_scss' );

		// always use the database defaults for these
		// as they're URLs that could be modified to anything
		$this->fbMsg = wfMessage( 'wikiahubs-v3-social-facebook-link' )
			->useDatabase( false )
			->inContentLanguage()
			->text();
		$this->twMsg = wfMessage( 'wikiahubs-v3-social-twitter-link' )
			->useDatabase( false )
			->inContentLanguage()
			->text();
		$this->gplusMsg = wfMessage( 'wikiahubs-v3-social-googleplus-link' )
			->useDatabase( false )
			->inContentLanguage()
			->text();
	}

}
