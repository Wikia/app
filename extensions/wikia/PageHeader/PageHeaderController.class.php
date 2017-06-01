<?php

namespace Wikia\PageHeader;

use CuratedContentHelper;

class PageHeaderController extends \WikiaController {

	public function index() {
		$this->setVal( 'pageTitle', new PageTitle( $this->app ) );
		$this->setVal( 'counter', new Counter( $this->app ) );
	}

	public function subtitle() {
		$this->setVal( 'subtitle', new Subtitle( $this->app ) );
	}

	public function editButton() {
		global $wgEnableCuratedContentExt;

		$skinVars = $this->app->getSkinTemplateObj()->data;
		$content_actions = $skinVars['content_actions'];

		$actions = [ 'edit', 've-edit', 'formedit', 'history', 'move', 'protect', 'unprotect', 'delete', 'undelete', 'replace-file' ];

		// Enable to modify actions list on dropdown
		wfRunHooks( 'PageHeaderDropdownActions', [ &$actions ] );

		$dropdownActions = [];
		foreach ( $actions as $action ) {
			if ( isset( $content_actions[$action] ) ) {
				if( $content_actions[$action]['main'] ?? false ) {
					$this->setVal( 'buttonAction', $content_actions[$action] );
				} else {
					$dropdownActions[$action] = $content_actions[$action];
				}
			}
		}

		if ( !empty( $wgEnableCuratedContentExt ) && CuratedContentHelper::shouldDisplayToolButton() ) {
			$dropdownActions[] = [
				'href' => '/main/edit?useskin=wikiamobile',
				'text' => wfMessage( 'wikiacuratedcontent-edit-mobile-main-page' )->escaped(),
				'id' => 'CuratedContentTool'
			];
		}

		$this->setVal('dropdownActions', $dropdownActions );
	}
}
