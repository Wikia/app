<?php

namespace Wikia\PageHeader;

use ArticleCommentInit;
use PageStatsService;
use RequestContext;
use Title;
use WikiaApp;
use WikiaPageType;

class ActionButton {
	const LOCK_ICON = 'wds-icons-lock-small';
	const EDIT_ICON = 'wds-icons-pencil-small';
	const PUBLISH_ICON = 'wds-icons-checkmark-small';

	private $contentActions;
	private $buttonAction;
	private $pageStatsService;
	private $title;
	private $user;
	private $request;
	private $buttonIcon = self::EDIT_ICON;
	private $shouldDisplay;

	public function __construct( WikiaApp $app ) {
		$requestContext = RequestContext::getMain();
		$skinVars = $app->getSkinTemplateObj()->data;
		$this->contentActions = $skinVars['content_actions'];

		$this->title = $requestContext->getTitle();
		$this->user = $requestContext->getUser();
		$this->request = $requestContext->getRequest();

		$this->pageStatsService = PageStatsService::newFromTitle( $this->title );

		$this->prepareActionButton();

		$shouldDisplay = (
			$this->hasHrefAndText() &&
			!$this->title->isSpecialPage() &&
			(
				!WikiaPageType::isCorporatePage() ||
				$this->canDisplayOnCorporatePage()
			)
		);

		\Hooks::run( 'PageHeaderActionButtonShouldDisplay', [ $this->title, &$shouldDisplay ] );

		$this->shouldDisplay = $shouldDisplay;
	}

	public function getTitle(): Title {
		return $this->title;
	}

	public function getButtonAction(): array {
		$this->buttonAction['data-tracking'] = $this->buttonAction['id'];
		$this->buttonAction['icon'] = $this->buttonIcon;

		return $this->buttonAction;
	}

	public function getDropdownActions(): array {
		// items to be added to "edit" dropdown
		$actions = [
			'edit',
			've-edit',
			'formedit',
			'history',
			'move',
			'protect',
			'unprotect',
			'delete',
			'undelete',
			'replace-file',
			'talk',
			'edit-mobile-main-page',
			'diff'
		];

		// Enable to modify actions list on dropdown
		\Hooks::run( 'PageHeaderDropdownActions', [ &$actions ] );

		return array_map( function( $action ) {
			$ret = $this->contentActions[$action];
			if ( isset( $ret['id'] ) ) {
				$ret['data-tracking'] = $ret['id'] . '-dropdown';
			}

			return $ret;
		}, array_filter( $actions, function( $action ) {
			return isset( $this->contentActions[$action] );
		}));
	}

	private function prepareActionButton() {
		\Hooks::run( 'BeforePrepareActionButtons', [ $this, &$this->contentActions ] );

		$isDiff = !is_null( $this->request->getVal( 'diff' ) );

		// "Add topic" action - remove on diff pages (RT #72666)
		if ( isset( $this->contentActions['addsection'] ) && $isDiff ) {
				unset( $this->contentActions['addsection'] );
		}

		if (isset($this->contentActions['publish'])) {
			$this->buttonAction = $this->contentActions['publish'];
			$this->buttonIcon = self::PUBLISH_ICON;
			unset($this->contentActions['publish']);
		}

		// handle protected pages (they should have viewsource link and lock icon) - BugId:9494
		if ( isset( $this->contentActions['viewsource'] ) &&
			!$this->title->isProtected() &&
			!$this->title->isNamespaceProtected( $this->user ) &&
			!$this->user->isLoggedIn() /* VOLDEV-74: logged in users should see the viewsource button, not edit */
		) {
			// force login to edit page that is not protected
			$this->contentActions['edit'] = $this->contentActions['viewsource'];
			$this->contentActions['edit']['text'] = wfMessage( 'page-header-action-button-edit' )->escaped();
			$this->buttonIcon = self::LOCK_ICON;
			unset( $this->contentActions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $this->contentActions['edit'] ) && $this->title->isCascadeProtected() ) {
			$this->contentActions['viewsource'] = $this->contentActions['edit'];
			$this->contentActions['viewsource']['text'] =
				wfMessage( 'page-header-action-button-viewsource' )->escaped();
			$this->buttonIcon = self::LOCK_ICON;
			unset( $this->contentActions['edit'] );
		}

		// "Add topic"
		if ( isset( $this->contentActions['addsection'] ) ) {
			$action = $this->contentActions['addsection'];
			$action['text'] = wfMessage( 'page-header-action-button-add-topic' )->escaped();
			$this->buttonAction = $action;
		}  // ve-edit
		else if ( isset( $this->contentActions['ve-edit'] ) && $this->contentActions['ve-edit']['main'] ) {
			$this->buttonAction = $this->contentActions['ve-edit'];
			unset( $this->contentActions['ve-edit'] );
		} // edit
		else if ( isset( $this->contentActions['edit'] ) ) {
			$this->buttonAction = $this->contentActions['edit'];
			unset( $this->contentActions['edit'] );
		} // view source
		else if ( isset( $this->contentActions['viewsource'] ) ) {
			$this->buttonAction = $this->contentActions['viewsource'];
			$this->buttonIcon = self::LOCK_ICON;
			unset( $this->contentActions['ve-edit'], $this->contentActions['edit'] );
		}

		if ( !$this->isArticleCommentsEnabled() ) {
			if ( isset( $this->contentActions['talk'] ) ) {
				$this->contentActions['talk']['text'] = wfMessage( 'page-header-action-button-talk' )
					->numParams( $this->pageStatsService->getCommentsCount() )
					->escaped();
			}
		} else {
			// when comments are enabled, we don't want to display "Discuss" in edit dropdown that is anchor to comments
			unset( $this->contentActions['talk'] );
		}
	}

	public function shouldDisplay(): bool {
		return $this->shouldDisplay;
	}

	private function isArticleCommentsEnabled(): bool {
		return class_exists( 'ArticleComment' ) &&
			ArticleCommentInit::ArticleCommentCheckTitle( $this->title );
	}

	private function canDisplayOnCorporatePage() {
		return WikiaPageType::isCorporatePage() && $this->user->isAllowed( 'edit' );
	}

	private function hasHrefAndText() {
		return !empty( $this->buttonAction['href'] ) && !empty( $this->buttonAction['text'] );
	}
}
