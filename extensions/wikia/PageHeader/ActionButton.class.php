<?php

namespace Wikia\PageHeader;

use CuratedContentHelper;

class ActionButton {
	private $contentActions;
	private $buttonAction;
	private $pageStatsService;
	private $title;

	public function __construct( \Title $title ) {
		$skinVars = \F::app()->getSkinTemplateObj()->data;
		$this->contentActions = $skinVars['content_actions'];
		$this->pageStatsService = \PageStatsService::newFromTitle( $title );
		$this->title = $title;

		$this->prepareActionButton();
	}

	public function getButtonAction(): array {
		$this->buttonAction['data-tracking'] = $this->buttonAction['id'];
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
			'edit-mobile-main-page'
		];

		// Enable to modify actions list on dropdown
		wfRunHooks( 'PageHeaderDropdownActions', [ &$actions ] );

		$ret = [];
		foreach ( $actions as $action ) {
			if ( isset( $this->contentActions[$action] ) ) {
				$ret[$action] = $this->contentActions[$action];
				if ( isset( $ret[$action]['id'])) {
					$ret[$action]['data-tracking'] = $ret[$action]['id'] . '-dropdown';
				}
			}
		}

		return $ret;
	}

	private function prepareActionButton() {
		global $wgTitle, $wgUser, $wgRequest, $wgEnableCuratedContentExt;

		wfRunHooks( 'BeforePrepareActionButtons', [ $this, &$this->contentActions ] );

		$isDiff = !is_null( $wgRequest->getVal( 'diff' ) );

		// "Add topic" action
		if ( isset( $this->contentActions['addsection'] ) ) {
			// remove on diff pages (RT #72666)
			if ( $isDiff ) {
				unset( $this->contentActions['addsection'] );
			}
		}

		// handle protected pages (they should have viewsource link and lock icon) - BugId:9494
		if ( isset( $this->contentActions['viewsource'] ) &&
			!$wgTitle->isProtected() &&
			!$wgTitle->isNamespaceProtected( $wgUser ) &&
			!$wgUser->isLoggedIn() /* VOLDEV-74: logged in users should see the viewsource button, not edit */
		) {
			// force login to edit page that is not protected
			$this->contentActions['edit'] = $this->contentActions['viewsource'];
			$this->contentActions['edit']['text'] = wfMessage( 'edit' )->escaped();
			unset( $this->contentActions['viewsource'] );
		}

		// If cascade protected, show viewsource button - BugId:VE-89
		if ( isset( $this->contentActions['edit'] ) && $wgTitle->isCascadeProtected() ) {
			$this->contentActions['viewsource'] = $this->contentActions['edit'];
			$this->contentActions['viewsource']['text'] = wfMessage( 'viewsource' )->escaped();
			unset( $this->contentActions['edit'] );
		}

		// "Add topic"
		if ( isset( $this->contentActions['addsection'] ) ) {
			$action = $this->contentActions['addsection'];
			$action['text'] = wfMsg( 'oasis-page-header-add-topic' );
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
			unset( $this->contentActions['ve-edit'], $this->contentActions['edit'] );
		}

		if ( !empty( $wgEnableCuratedContentExt ) && CuratedContentHelper::shouldDisplayToolButton() ) {
			$this->contentActions['edit-mobile-main-page'] = [
				'href' => '/main/edit?useskin=wikiamobile',
				'text' => wfMessage( 'wikiacuratedcontent-edit-mobile-main-page' )->escaped(),
				'id' => 'CuratedContentTool'
			];
		}

		if ( !$this->isArticleCommentsEnabled() ) {
			$this->contentActions['talk']['text'] = wfMessage( 'page-header-action-button-talk' )
				->numParams( $this->pageStatsService->getCommentsCount() )
				->escaped();
		}
	}

	private function isArticleCommentsEnabled(): bool {
		return class_exists( 'ArticleComment' ) && \ArticleCommentInit::ArticleCommentCheckTitle( $this->title );
	}
}