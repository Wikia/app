<?php
use Wikia\Logger\WikiaLogger;

/**
 * Renders page header (title, subtitle, comments chicklet button, history dropdown)
 *
 * @author Maciej Brencz
 */

class PageHeaderController extends WikiaController {

	var $content_actions;

	/* @var SkinTemplate */
	private $skinTemplate;

	public function init() {
		$this->isMainPage = null;
		$this->tallyMsg = null;

		$this->action = null;
		$this->actionImage = null;
		$this->actionName = null;
		$this->dropdown = null;

		$this->skinTemplate = $this->app->getSkinTemplateObj();

		$skinVars = $this->skinTemplate->data;
		$this->content_actions = $skinVars['content_actions'];
		$this->displaytitle = $skinVars['displaytitle']; // if true - don't encode HTML
		$this->title = $skinVars['title'];
		$this->subtitle = $skinVars['subtitle'];
	}

	/**
	 * Use MW core variable to generate action button
	 */
	protected function prepareActionButton() {

		global $wgTitle, $wgUser, $wgRequest;

		$isDiff = !is_null( $wgRequest->getVal( 'diff' ) );

		// "Add topic" action
		if ( isset( $this->content_actions['addsection'] ) ) {
			// remove on diff pages (RT #72666)
			if ( $isDiff ) {
				unset( $this->content_actions['addsection'] );
			}
		}

		// action button
		# print_pre($this->content_actions);

		// handle protected pages (they should have viewsource link and lock icon) - BugId:9494
		if ( isset( $this->content_actions['viewsource'] ) &&
			!$wgTitle->isProtected() &&
			!$wgTitle->isNamespaceProtected( $wgUser ) &&
			!$wgUser->isLoggedIn() /* VOLDEV-74: logged in users should see the viewsource button, not edit */
		) {
			// force login to edit page that is not protected
			$this->content_actions['edit'] = $this->content_actions['viewsource'];
			$this->content_actions['edit']['text'] = wfMessage( 'edit' )->text();
			unset( $this->content_actions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $this->content_actions['edit'] ) && $wgTitle->isCascadeProtected() ) {
			$this->content_actions['viewsource'] = $this->content_actions['edit'];
			$this->content_actions['viewsource']['text'] = wfMessage( 'viewsource' )->text();
			unset( $this->content_actions['edit'] );
		}

		// "Add topic"
		if ( isset( $this->content_actions['addsection'] ) ) {
			$action = $this->content_actions['addsection'];
			$action['text'] = wfMsg( 'oasis-page-header-add-topic' );
			$this->action = $action;

			$this->actionImage = MenuButtonController::ADD_ICON;
			$this->actionName = 'addtopic';
		}
		// "Edit with form" (SMW)
		else if ( isset( $this->content_actions['form_edit'] ) ) {
			$this->action = $this->content_actions['form_edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 'form-edit';
		}
		// ve-edit
		else if ( isset( $this->content_actions['ve-edit'] ) && $this->content_actions['ve-edit']['main'] ) {
			$this->action = $this->content_actions['ve-edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 've-edit';
			unset( $this->content_actions['ve-edit'] );
		}
		// edit
		else if ( isset( $this->content_actions['edit'] ) ) {
			$this->action = $this->content_actions['edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 'edit';
			unset( $this->content_actions['edit'] );
		}
		// view source
		else if ( isset( $this->content_actions['viewsource'] ) ) {
			$this->action = $this->content_actions['viewsource'];
			$this->actionImage = MenuButtonController::LOCK_ICON;
			$this->actionName = 'source';
			unset( $this->content_actions['ve-edit'], $this->content_actions['edit'] );
		}

		# print_pre($this->action); print_pre($this->actionImage); print_pre($this->actionName);
	}

	/**
	 * Get content actions for dropdown
	 */
	protected function getDropdownActions() {
		$ret = array();

		$editActions = array();
		if ( isset( $this->content_actions['edit'] ) ) {
			array_push( $editActions, 'edit' );
		}
		if ( isset( $this->content_actions['ve-edit'] ) ) {
			if ( $this->content_actions['ve-edit']['main'] ) {
				array_unshift( $editActions, 've-edit' );
			} else {
				array_push( $editActions, 've-edit' );
			}
		}

		// items to be added to "edit" dropdown
		$actions = array_merge( $editActions,
			array( 'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file' ) );

		// Enable to modify actions list on dropdown
		wfRunHooks( 'PageHeaderDropdownActions', [ &$actions ] );

		foreach ( $actions as $action ) {
			if ( isset( $this->content_actions[$action] ) ) {
				$ret[$action] = $this->content_actions[$action];
			}
		}

		return $ret;
	}

	private function getCuratedContentButton() {
		global $wgEnableCuratedContentExt;

		if ( !empty( $wgEnableCuratedContentExt ) ) {
			return $this->app->sendRequest( 'CuratedContent', 'editButton' );
		} else {
			return null;
		}
	}

	/**
	 * Render default page header (with edit dropdown, history dropdown, ...)
	 *
	 * @param: array $params
	 *    key: showSearchBox (default: false)
	 */
	public function executeIndex( $params ) {
		global $wgTitle, $wgArticle, $wgOut, $wgUser, $wgContLang, $wgSupressPageTitle, $wgSupressPageSubtitle,
			$wgSuppressNamespacePrefix, $wgEnableWallExt;

		wfProfileIn( __METHOD__ );

		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// check for video add button permissions
		$this->showAddVideoBtn = $wgUser->isAllowed( 'videoupload' );

		// page namespace
		$ns = $wgTitle->getNamespace();

		$this->curatedContentToolButton = $this->getCuratedContentButton();

		/** start of wikia changes @author nAndy */
		$this->isWallEnabled = ( !empty( $wgEnableWallExt ) && $ns == NS_USER_WALL );
		/** end of wikia changes */

		// currently used skin
		$skin = RequestContext::getMain()->getSkin();

		// action button (edit / view soruce) and dropdown for it
		$this->prepareActionButton();

		// dropdown actions
		$this->dropdown = $this->getDropdownActions();

		/** start of wikia changes @author nAndy */
		$response = $this->getResponse();
		if ( $response instanceof WikiaResponse ) {
			wfRunHooks( 'PageHeaderIndexAfterActionButtonPrepared', array( $response, $ns, $skin ) );
			/** @author Jakub */
			$this->extraButtons = array();
			wfRunHooks( 'PageHeaderIndexExtraButtons', array( $response ) );
		} else {
			// it happened on TimQ's devbox that $response was probably null fb#28747
			WikiaLogger::instance()->error('Response not an instance of WikiaResponse', [
				'ex' => new Exception()
			]);
		}
		/** end of wikia changes */

		// for not existing pages page header is a bit different
		$this->pageExists = !empty( $wgTitle ) && $wgTitle->exists();

		// default title "settings" (RT #145371), don't touch special pages
		if ( $ns != NS_SPECIAL ) {
			$this->displaytitle = true;
			$this->title = $wgOut->getPageTitle();
		}
		else {
			// on special pages titles are already properly encoded (BugId:5983)
			$this->displaytitle = true;
		}

		// perform namespace and special page check

		// use service to get data
		$service = PageStatsService::newFromTitle( $wgTitle );

		// comments - moved here to display comments even on deleted/non-existant pages
		$this->comments = $service->getCommentsCount();

		if ( $this->pageExists ) {

			// mainpage?
			if ( WikiaPageType::isMainPage() ) {
				$this->isMainPage = true;
			}

			// number of pages on this wiki
			$this->tallyMsg = wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse();

		}

		// remove namespaces prefix from title
		$namespaces = array( NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE );

		if ( in_array( $ns, array_merge( $namespaces, $wgSuppressNamespacePrefix ) ) ) {
			$this->title = $wgTitle->getText();
			$this->displaytitle = false;
		}

		// talk pages
		if ( $wgTitle->isTalkPage() ) {
			// remove comments & FB like button
			$this->comments = false;

			// Talk: <page name without namespace prefix>
			$this->displaytitle = true;
			$this->title = Xml::element( 'strong', array(), $wgContLang->getNsText( NS_TALK ) . ':' );
			$this->title .= htmlspecialchars( $wgTitle->getText() );

			// back to subject article link
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

			$this->pageTalkSubject = Wikia::link( $wgTitle->getSubjectPage(), wfMsg( $msgKey ), array( 'accesskey' => 'c' ) );
		}

		// forum namespace
		if ( $ns == NS_FORUM ) {
			// remove comments button
			$this->comments = false;

			// remove namespace prefix
			$this->title = $wgTitle->getText();
			$this->displaytitle = false;
		}

		// mainpage
		if ( WikiaPageType::isMainPage() ) {
			// change page title to just "Home"
			$this->title = wfMsg( 'oasis-home' );
		}

		// render page type info
		switch( $ns ) {
			case NS_MEDIAWIKI:
				$this->pageType = wfMsg( 'oasis-page-header-subtitle-mediawiki' );
				break;

			case NS_TEMPLATE:
				$this->pageType = wfMsg( 'oasis-page-header-subtitle-template' );
				break;

			case NS_SPECIAL:
				$this->pageType = wfMsg( 'oasis-page-header-subtitle-special' );

				// remove comments button (fix FB#3404 - Marooned)
				$this->comments = false;

				if ( $wgTitle->isSpecial( 'Images' ) ) {
					$this->isSpecialImages = true;
				}

				if ( $wgTitle->isSpecial( 'Videos' ) ) {
					$this->isSpecialVideos = true;
					$mediaService = ( new MediaQueryService );
					$this->tallyMsg = wfMessage( 'specialvideos-wiki-videos-tally', $mediaService->getTotalVideos() )->parse();
				}

				break;

			case NS_CATEGORY:
				$this->pageType = wfMsg( 'oasis-page-header-subtitle-category' );
				break;

			case NS_FORUM:
				$this->pageType = wfMsg( 'oasis-page-header-subtitle-forum' );
				break;
		}
		wfRunHooks( 'PageHeaderPageTypePrepared', [ $this, $this->getContext()->getTitle() ] );

		// render subpage info
		$this->pageSubject = $skin->subPageSubtitle();

		if ( in_array( $wgTitle->getNamespace(), BodyController::getUserPagesNamespaces() ) ) {
			$title = explode( ':', $this->title, 2 ); // User:Foo/World_Of_Warcraft:_Residers_in_Shadows (BAC-494)
			if ( count( $title ) >= 2 && $wgTitle->getNsText() == str_replace( ' ', '_', $title[0] ) ) // in case of error page (showErrorPage) $title is just a string (cannot explode it)
				$this->title = $title[1];
		}

		// render MW subtitle (contains old revision data)
		$this->subtitle = $wgOut->getSubtitle();

		// render redirect info (redirected from)
		if ( !empty( $wgArticle->mRedirectedFrom ) ) {
			$this->pageRedirect = trim( $this->subtitle, '()' );
			$this->subtitle = '';
		}

		// render redirect page (redirect to)
		if ( $wgTitle->isRedirect() ) {
			$this->pageType = $this->subtitle;
			$this->subtitle = '';
		}

		if ( !empty( $wgSupressPageTitle ) ) {
			$this->title = '';
			$this->subtitle = '';
		}

		if ( !empty( $wgSupressPageSubtitle ) ) {
			$this->subtitle = '';
			$this->pageSubtitle = '';
		}
		else {
			// render pageType, pageSubject and pageSubtitle as one message
			$subtitle = array_filter( array(
				$this->pageType,
				$this->pageTalkSubject,
				$this->pageSubject,
				$this->pageRedirect,
			) );

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
					$subtitle[] = Xml::element(
						'a',
						array(
							'href' => $variant['href'],
							'rel' => 'nofollow',
							'id' => $variant['id']
						),
						$variant['text']
					);
				}
			}

			$pipe = wfMsg( 'pipe-separator' );
			$this->pageSubtitle = implode( " {$pipe} ", $subtitle );
		}

		// force AjaxLogin popup for "Add a page" button (moved from the template)
		$this->loginClass = !empty( $this->wg->DisableAnonymousEditing ) ? ' require-login' : '';

		// render monetization module
		if ( !empty( $params['monetizationModules'] ) ) {
			$this->monetizationModules = $params['monetizationModules'];
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Render header for edit page
	 */
	public function executeEditPage() {
		global $wgTitle, $wgRequest, $wgSuppressToolbar, $wgShowMyToolsOnly, $wgEnableWallExt;
		wfProfileIn( __METHOD__ );

		// special handling for special pages (CreateBlogPost, CreatePage)
		$ns = $wgTitle->getNamespace();
		if ( $ns == NS_SPECIAL ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		// detect section edit
		$isSectionEdit = is_numeric( $wgRequest->getVal( 'section' ) );

		// show proper message in the header
		$action = $wgRequest->getVal( 'action', 'view' );

		$isPreview = $wgRequest->getCheck( 'wpPreview' ) || $wgRequest->getCheck( 'wpLivePreview' );
		$isShowChanges = $wgRequest->getCheck( 'wpDiff' );
		$isDiff = !is_null( $wgRequest->getVal( 'diff' ) ); // RT #69931
		$isEdit = in_array( $action, array( 'edit', 'submit' ) );
		$isHistory = $action == 'history';

		/** start of wikia changes @author nAndy */
		$this->isHistory = $isHistory;
		$this->isUserTalkArchiveModeEnabled = ( !empty( $wgEnableWallExt ) && $ns == NS_USER_TALK );
		/** end of wikia changes */

		// add editor's right rail when not editing main page
		if ( !Wikia::isMainPage() ) {
			OasisController::addBodyClass( 'editor-rail' );
		}

		// hide floating toolbar when on edit page / in preview mode / show changes
		if ( $isEdit || $isPreview ) {
			$wgSuppressToolbar = true;
		}

		// choose header message
		if ( $isPreview ) {
			$titleMsg = 'oasis-page-header-preview';
		}
		else if ( $isShowChanges ) {
			$titleMsg = 'oasis-page-header-changes';
		}
		else if ( $isDiff ) {
			$titleMsg = 'oasis-page-header-diff';
		}
		else if ( $isSectionEdit ) {
			$titleMsg = 'oasis-page-header-editing-section';
		}
		else if ( $isHistory ) {
			$titleMsg = 'oasis-page-header-history';
		}
		else {
			$titleMsg = 'oasis-page-header-editing';
		}

		$this->displaytitle = true;
		$this->title = wfMsg( $titleMsg, htmlspecialchars( $wgTitle->getPrefixedText() ) );

		// back to article link
		if ( !$isPreview && !$isShowChanges ) {
			$this->subtitle = Wikia::link( $wgTitle, wfMsg( 'oasis-page-header-back-to-article' ), array( 'accesskey' => 'c' ), array(), 'known' );
		}

		// add edit button
		if ( $isDiff || ( $isHistory && !$this->isUserTalkArchiveModeEnabled ) ) {
			$this->prepareActionButton();

			// show only "My Tools" dropdown on toolbar
			$wgShowMyToolsOnly = true;
		}

		// render edit dropdown / commments chicklet on history pages
		if ( $isHistory ) {
			// FB#1137 - re-add missing log and undelete links
			$logPage = SpecialPage::getTitleFor( 'Log' );
			$this->subtitle .= ' | ' . Wikia::link(
				$logPage,
				wfMsgHtml( 'viewpagelogs' ),
				array(),
				array( 'page' => $wgTitle->getPrefixedText() ),
				array( 'known', 'noclasses' )
			);

			// FIXME: Skin is now an abstract class (MW1.19)
			// (wladek) created non-abstract FakeSkin class, is it the correct solution?
			$sk = new FakeSkin();
			$sk->setRelevantTitle( $wgTitle );

			$undeleteLink = $sk->getUndeleteLink();

			if ( !empty( $undeleteLink ) ) {
				$this->subtitle .= ' | ' . $undeleteLink;
			}

			// dropdown actions
			$this->dropdown = $this->getDropdownActions();

			// use service to get data
			$service = new PageStatsService( $wgTitle->getArticleId() );

			// comments
			$this->comments = $service->getCommentsCount();
		}

		wfRunHooks( 'PageHeaderEditPage', array( &$this, $ns, $isPreview, $isShowChanges, $isDiff, $isEdit, $isHistory ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render edit box header when doing preview / showing changes
	 */
	public function executeEditBox() {
		global $wgTitle, $wgRequest;

		// detect section edit
		$isSectionEdit = is_numeric( $wgRequest->getVal( 'wpSection' ) );

		if ( $isSectionEdit ) {
			$msg = 'oasis-page-header-editing-section';
		}
		else {
			$msg = 'oasis-page-header-editing';
		}

		// Editing: foo
		$this->displaytitle = true;
		$this->title = wfMsg( $msg, htmlspecialchars( $wgTitle->getPrefixedText() ) );

		// back to article link
		$this->subtitle = Wikia::link( $wgTitle, wfMsg( 'oasis-page-header-back-to-article' ), array( 'accesskey' => 'c' ), array(), 'known' );
	}

	/**
	 * Called instead of executeIndex when the CorporatePage extension is enabled.
	 */
	public function executeCorporate() {
		global $wgTitle, $wgOut, $wgUser, $wgSuppressNamespacePrefix;
		wfProfileIn( __METHOD__ );

		$this->canAct = $wgUser->isAllowed( 'edit' );
		if ( $this->canAct ) {
			$this->prepareActionButton();
			// dropdown actions
			$this->dropdown = $this->getDropdownActions();
		}

		// page namespace
		$ns = $wgTitle->getNamespace();

		// default title "settings" (RT #145371), don't touch special pages
		if ( $ns == NS_FORUM ) {
			$this->title = $wgTitle->getText();
			$this->displaytitle = false;
		// we don't want htmlspecialchars for SpecialPages (BugId:6012)
		} else if ( $ns == NS_SPECIAL ) {
			$this->displaytitle = true;
		} else if ( $ns != NS_SPECIAL ) {
			$this->displaytitle = true;
			$this->title = $wgOut->getPageTitle();
		}

		// remove namespaces prefix from title
		$namespaces = array( NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE );

		if ( in_array( $ns, array_merge( $namespaces, $wgSuppressNamespacePrefix ) ) ) {
			$this->title = $wgTitle->getText();
			$this->displaytitle = false;
		}

		if ( WikiaPageType::isMainPage() ) {
			$this->title = '';
			$this->subtitle = '';
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render page header for Hubs
	 *
	 * @param: array $params
	 */
	public function executeHubs( $params ) {
		global $wgSupressPageTitle;

		wfProfileIn( __METHOD__ );

		$this->displaytitle = true;
		// Leave this for now. To discuss do we want PageTitle
		if ( $this->displaytitle ) {
			$this->title = wfMessage( 'oasis-home' )->escaped();
		}

		// number of pages on this wiki
		$this->tallyMsg = wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse();

		if ( !empty( $wgSupressPageTitle ) ) {
			$this->title = '';
		}

		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete( &$article, &$user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		global $wgMemc;
		$wgMemc->delete( wfMemcKey( 'mOasisRecentRevisions2', $article->getTitle()->getArticleId() ) );
		return true;
	}

}
