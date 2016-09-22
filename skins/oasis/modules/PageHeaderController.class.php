<?php
use Wikia\Logger\WikiaLogger;

/**
 * Renders page header (title, subtitle, comments chicklet button, history dropdown)
 *
 * @author Maciej Brencz
 */
class PageHeaderController extends WikiaController {

	var $content_actions;

	/* @var WikiaSkinTemplate $skinTemplate */
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
		$isDiff = !is_null( $this->wg->Request->getVal( 'diff' ) );

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
			!$this->wg->Title->isProtected() &&
			!$this->wg->Title->isNamespaceProtected( $this->wg->User ) &&
			!$this->wg->User->isLoggedIn() /* VOLDEV-74: logged in users should see the viewsource button, not edit */
		) {
			// force login to edit page that is not protected
			$this->content_actions['edit'] = $this->content_actions['viewsource'];
			$this->content_actions['edit']['text'] = wfMessage( 'edit' )->text();
			unset( $this->content_actions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $this->content_actions['edit'] ) && $this->wg->Title->isCascadeProtected() ) {
			$this->content_actions['viewsource'] = $this->content_actions['edit'];
			$this->content_actions['viewsource']['text'] = wfMessage( 'viewsource' )->text();
			unset( $this->content_actions['edit'] );
		}

		// "Add topic"
		if ( isset( $this->content_actions['addsection'] ) ) {
			$action = $this->content_actions['addsection'];
			$action['text'] = wfMessage( 'oasis-page-header-add-topic' )->text();
			$this->action = $action;

			$this->actionImage = MenuButtonController::ADD_ICON;
			$this->actionName = 'addtopic';
		} // "Edit with form" (SMW)
		else if ( isset( $this->content_actions['form_edit'] ) ) {
			$this->action = $this->content_actions['form_edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 'form-edit';
		} // ve-edit
		else if ( isset( $this->content_actions['ve-edit'] ) && $this->content_actions['ve-edit']['main'] ) {
			$this->action = $this->content_actions['ve-edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 've-edit';
			unset( $this->content_actions['ve-edit'] );
		} // edit
		else if ( isset( $this->content_actions['edit'] ) ) {
			$this->action = $this->content_actions['edit'];
			$this->actionImage = MenuButtonController::EDIT_ICON;
			$this->actionName = 'edit';
			unset( $this->content_actions['edit'] );
		} // view source
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
		$ret = [];

		$editActions = [ ];
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
			[ 'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file' ] );

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
		if ( !empty( $this->wg->EnableCuratedContentExt ) ) {
			return $this->app->sendRequest( 'CuratedContent', 'editButton' );
		} else {
			return null;
		}
	}

	/**
	 * Render default page header (with edit dropdown, history dropdown, ...)
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->isUserLoggedIn = $this->wg->User->isLoggedIn();

		// check for video add button permissions
		$this->showAddVideoBtn = $this->wg->User->isAllowed( 'videoupload' );

		// page namespace
		$ns = $this->wg->Title->getNamespace();

		$this->curatedContentToolButton = $this->getCuratedContentButton();

		$this->isWallEnabled = ( !empty( $this->wg->EnableWallExt ) && $ns == NS_USER_WALL );

		// currently used skin
		$skin = RequestContext::getMain()->getSkin();

		// action button (edit / view soruce) and dropdown for it
		$this->prepareActionButton();

		// dropdown actions
		$this->dropdown = $this->getDropdownActions();

		/** start of wikia changes @author nAndy */
		$response = $this->getResponse();
		if ( $response instanceof WikiaResponse ) {
			wfRunHooks( 'PageHeaderIndexAfterActionButtonPrepared', [ $response, $ns, $skin ] );
			/** @author Jakub */
			$this->extraButtons = [ ];
			wfRunHooks( 'PageHeaderIndexExtraButtons', [ $response ] );
		} else {
			// it happened on TimQ's devbox that $response was probably null fb#28747
			WikiaLogger::instance()->error( 'Response not an instance of WikiaResponse', [
				'ex' => new Exception(),
			] );
		}
		/** end of wikia changes */

		// for not existing pages page header is a bit different
		$this->pageExists = !empty( $this->wg->Title ) && $this->wg->Title->exists();

		// default title "settings" (RT #145371), don't touch special pages
		if ( $ns != NS_SPECIAL ) {
			$this->displaytitle = true;
			$this->title = $this->wg->Out->getPageTitle();
		} else {
			// on special pages titles are already properly encoded (BugId:5983)
			$this->displaytitle = true;
		}

		// perform namespace and special page check

		// use service to get data
		$service = PageStatsService::newFromTitle( $this->wg->Title );

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
		$namespaces = [ NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE ];

		if ( in_array( $ns, array_merge( $namespaces, $this->wg->SuppressNamespacePrefix ) ) ) {
			$this->title = $this->wg->Title->getText();
			$this->displaytitle = false;
		}

		// talk pages
		if ( $this->wg->Title->isTalkPage() ) {
			// remove comments & FB like button
			$this->comments = false;

			// Talk: <page name without namespace prefix>
			$this->displaytitle = true;
			$this->title = Xml::element( 'strong', [ ], $this->wg->ContLang->getNsText( NS_TALK ) . ':' );
			$this->title .= htmlspecialchars( $this->wg->Title->getText() );

			// back to subject article link
			switch ( $ns ) {
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

			$this->pageTalkSubject = Linker::link( $this->wg->Title->getSubjectPage(), wfMessage( $msgKey )->escaped(), [ 'accesskey' => 'c' ] );
		}

		// forum namespace
		if ( $ns == NS_FORUM ) {
			// remove comments button
			$this->comments = false;

			// remove namespace prefix
			$this->title = $this->wg->Title->getText();
			$this->displaytitle = false;
		}

		// mainpage
		if ( WikiaPageType::isMainPage() ) {
			// change page title to just "Home"
			$this->title = wfMessage( 'oasis-home' )->escaped();
		}

		// render page type info
		switch ( $ns ) {
			case NS_MEDIAWIKI:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-mediawiki' )->escaped();
				break;

			case NS_TEMPLATE:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-template' )->escaped();
				break;

			case NS_SPECIAL:
				$this->pageType = wfMessage( 'oasis-page-header-subtitle-special' )->escaped();

				// remove comments button (fix FB#3404 - Marooned)
				$this->comments = false;

				if ( $this->wg->Title->isSpecial( 'Images' ) ) {
					$this->isSpecialImages = true;
				}

				if ( $this->wg->Title->isSpecial( 'Videos' ) ) {
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

		if ( in_array( $this->wg->Title->getNamespace(), BodyController::getUserPagesNamespaces() ) ) {
			$title = explode( ':', $this->title, 2 ); // User:Foo/World_Of_Warcraft:_Residers_in_Shadows (BAC-494)
			if ( count( $title ) >= 2 && $this->wg->Title->getNsText() == str_replace( ' ', '_', $title[0] ) ) // in case of error page (showErrorPage) $title is just a string (cannot explode it)
				$this->title = $title[1];
		}

		// render MW subtitle (contains old revision data)
		$this->subtitle = $this->wg->Out->getSubtitle();

		// render redirect info (redirected from)
		if ( !empty( $this->wg->Article->mRedirectedFrom ) ) {
			$this->pageRedirect = trim( $this->subtitle, '()' );
			$this->subtitle = '';
		}

		// render redirect page (redirect to)
		if ( $this->wg->Title->isRedirect() ) {
			$this->pageType = $this->subtitle;
			$this->subtitle = '';
		}

		if ( !empty( $this->wg->SupressPageTitle ) ) {
			$this->title = '';
			$this->subtitle = '';
		}

		if ( !empty( $this->wg->SupressPageSubtitle ) ) {
			$this->subtitle = '';
			$this->pageSubtitle = '';
		} else {
			// render pageType, pageSubject and pageSubtitle as one message
			$subtitle = array_filter( [
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
					$subtitle[] = Xml::element(
						'a',
						[
							'href' => $variant['href'],
							'rel'  => 'nofollow',
							'id'   => $variant['id'],
						],
						$variant['text']
					);
				}
			}

			$pipe = wfMessage( 'pipe-separator' )->escaped();
			$this->pageSubtitle = implode( " {$pipe} ", $subtitle );
		}

		// force AjaxLogin popup for "Add a page" button (moved from the template)
		$this->loginClass = !empty( $this->wg->DisableAnonymousEditing ) ? ' require-login' : '';

		// render monetization module
		$this->monetizationModules = $this->request->getArray( 'monetizationModules' );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render header for edit page
	 */
	public function editPage() {
		// special handling for special pages (CreateBlogPost, CreatePage)
		if ( $this->wg->Title->isSpecialPage() ) {
			return;
		}
		wfProfileIn( __METHOD__ );

		// detect section edit
		$isSectionEdit = is_numeric( $this->wg->Request->getVal( 'section' ) );

		// show proper message in the header
		$action = $this->wg->Request->getVal( 'action', 'view' );

		$isPreview = $this->wg->Request->getCheck( 'wpPreview' ) || $this->wg->Request->getCheck( 'wpLivePreview' );
		$isShowChanges = $this->wg->Request->getCheck( 'wpDiff' );
		$isDiff = !is_null( $this->wg->Request->getVal( 'diff' ) ); // RT #69931
		$isEdit = in_array( $action, [ 'edit', 'submit' ] );
		$isHistory = $action == 'history';

		/** start of wikia changes @author nAndy */
		$this->isHistory = $isHistory;
		$this->isUserTalkArchiveModeEnabled = ( !empty( $this->wg->EnableWallExt ) && $this->wg->Title->inNamespace( NS_USER_TALK ) );
		/** end of wikia changes */

		// add editor's right rail when not editing main page
		if ( !Wikia::isMainPage() ) {
			OasisController::addBodyClass( 'editor-rail' );
		}

		// hide floating toolbar when on edit page / in preview mode / show changes
		if ( $isEdit || $isPreview ) {
			$this->wg->SuppressToolbar = true;
		}

		// choose header message
		if ( $isPreview ) {
			$titleMsg = 'oasis-page-header-preview';
		} else if ( $isShowChanges ) {
			$titleMsg = 'oasis-page-header-changes';
		} else if ( $isDiff ) {
			$titleMsg = 'oasis-page-header-diff';
		} else if ( $isSectionEdit ) {
			$titleMsg = 'oasis-page-header-editing-section';
		} else if ( $isHistory ) {
			$titleMsg = 'oasis-page-header-history';
		} else {
			$titleMsg = 'oasis-page-header-editing';
		}

		$this->displaytitle = true;
		$this->title = wfMessage( $titleMsg, $this->wg->Title->getPrefixedText() )->parse();

		// back to article link
		if ( !$isPreview && !$isShowChanges ) {
			$this->subtitle = Linker::linkKnown( $this->wg->Title, wfMessage( 'oasis-page-header-back-to-article' )->escaped(), [ 'accesskey' => 'c' ] );
		}

		// add edit button
		if ( $isDiff || ( $isHistory && !$this->isUserTalkArchiveModeEnabled ) ) {
			$this->prepareActionButton();

			// show only "My Tools" dropdown on toolbar
			$this->wg->ShowMyToolsOnly = true;
		}

		// render edit dropdown / commments chicklet on history pages
		if ( $isHistory ) {
			// FB#1137 - re-add missing log and undelete links
			$logPage = SpecialPage::getTitleFor( 'Log' );
			$this->subtitle .= wfMessage( 'pipe-separator' )->escaped() . Linker::linkKnown(
					$logPage,
					wfMessage( 'viewpagelogs' )->escaped(),
					[ ],
					[ 'page' => $this->wg->Title->getPrefixedText() ]
				);

			$undeleteLink = $this->getContext()->getSkin()->getUndeleteLink();

			if ( !empty( $undeleteLink ) ) {
				$this->subtitle .= wfMessage( 'pipe-separator' )->escaped() . $undeleteLink;
			}

			// dropdown actions
			$this->dropdown = $this->getDropdownActions();

			// use service to get data
			$service = new PageStatsService( $this->wg->Title->getArticleID() );

			// comments
			$this->comments = $service->getCommentsCount();
		}

		Hooks::run( 'PageHeaderEditPage', [ &$this, $this->wg->Title->getNamespace(), $isPreview, $isShowChanges, $isDiff, $isEdit, $isHistory ] );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render edit box header when doing preview / showing changes
	 */
	public function editBox() {
		global $wgTitle;

		// detect section edit
		$isSectionEdit = is_numeric( $this->wg->Request->getVal( 'wpSection' ) );

		if ( $isSectionEdit ) {
			$msg = 'oasis-page-header-editing-section';
		} else {
			$msg = 'oasis-page-header-editing';
		}

		// Editing: foo
		$this->displaytitle = true;
		$this->title = wfMessage( $msg, $this->wg->Title->getPrefixedText() )->parse();

		// back to article link
		$this->subtitle = Linker::linkKnown( $this->wg->Title, wfMessage( 'oasis-page-header-back-to-article' )->escaped(), [ 'accesskey' => 'c' ] );
	}

	/**
	 * Called instead of index when the CorporatePage extension is enabled.
	 */
	public function corporate() {
		wfProfileIn( __METHOD__ );

		$this->canAct = $this->wg->User->isAllowed( 'edit' );
		if ( $this->canAct ) {
			$this->prepareActionButton();
			// dropdown actions
			$this->dropdown = $this->getDropdownActions();
		}

		// page namespace
		$ns = $this->wg->Title->getNamespace();

		// default title "settings" (RT #145371), don't touch special pages
		if ( $ns == NS_FORUM ) {
			$this->title = $this->wg->Title->getText();
			$this->displaytitle = false;
			// we don't want htmlspecialchars for SpecialPages (BugId:6012)
		} else if ( $ns == NS_SPECIAL ) {
			$this->displaytitle = true;
		} else if ( $ns != NS_SPECIAL ) {
			$this->displaytitle = true;
			$this->title = $this->wg->Out->getPageTitle();
		}

		// remove namespaces prefix from title
		$namespaces = [ NS_MEDIAWIKI, NS_TEMPLATE, NS_CATEGORY, NS_FILE ];

		if ( in_array( $ns, array_merge( $namespaces, $this->wg->SuppressNamespacePrefix ) ) ) {
			$this->title = $this->wg->Title->getText();
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
	 */
	public function hubs() {
		wfProfileIn( __METHOD__ );

		$this->displaytitle = true;
		// Leave this for now. To discuss do we want PageTitle
		if ( $this->displaytitle ) {
			$this->title = wfMessage( 'oasis-home' )->escaped();
		}

		// number of pages on this wiki
		$this->tallyMsg = wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse();

		if ( !empty( $this->wg->SupressPageTitle ) ) {
			$this->title = '';
		}

		wfProfileOut( __METHOD__ );
	}

	static function onArticleSaveComplete( &$article, &$user, $text, $summary,
										   $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		F::app()->wg->Memc->delete( wfMemcKey( 'mOasisRecentRevisions2', $article->getTitle()->getArticleId() ) );
		return true;
	}

}
