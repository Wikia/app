<?php

class WikiaMobileEditorController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * @brief   Returns true
	 * @details Adds assets needed on Edit page on WikiaMobile skin
	 *
	 * @return true
	 */
	public static function onWikiaMobileAssetsPackages ( &$head, &$body, &$scss ) {

		$wg = F::app()->wg;
		$action = $wg->Request->getVal( 'action' );

		if ( $action == 'edit' || $action == 'submit' ) {
			$body[] = 'wikiamobile_editor_js';
			$scss[] = 'wikiamobile_editor_scss';
		} else if ( $action == 'view' || is_null( $action ) && $wg->User->isLoggedIn() ) {
			$scss[] = 'wikiamobile_editor_view_scss';
		}

		return true;
	}

	/**
	 * @brief   Returns true
	 * @details This function doesn't actually do anything - handler for MediaWiki hook
	 *
	 * @param OutputPage &$out  MediaWiki OutputPage passed by reference
	 * @param string     &$text The article contents passed by reference
	 *
	 * @return true
	 */
	public static function onEditPageInitial ( EditPage $editPage ) {
		$app = F::app();

		if ( $app->checkSkin( 'wikiamobile' ) ) {
			//We want mobile editing to be as clean as possible
			WikiaMobileNavigationService::setSkipRendering( true );
			WikiaMobileFooterService::setSkipRendering( true );

			$editPage->editFormTextBottom .= $app->renderView( __CLASS__, 'editPage' );
		}

		return true;
	}

	/**
	 * @desc Mark all edits made via mobile skin with a mobileedit tag
	 *
	 * @param $article
	 * @param $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision Revision
	 * @param $status
	 * @param $baseRevId
	 */
	public static function onArticleSaveComplete ( &$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId ) {
		$app = F::app();

		//Add Mobile Edit tag when an article was saved via mobile skin
		if ( $app->checkSkin( 'wikiamobile' ) && !is_null( $revision ) ) {
			ChangeTags::addTags(
				'mobileedit',
				null,
				$revision->getId(),
				null
			);
		}

		return true;
	}

	public function editPage () {
		$this->response->setVal( 'articleUrl', $this->app->wg->Title->getLocalUrl() );

		JSMessages::enqueuePackage( 'wikiamobileeditor', JSMessages::INLINE );

		$this->response->setVal( 'cancel', wfMessage( 'wikiamobileeditor-cancel' )->text() );
		$this->response->setVal( 'preview', wfMessage( 'wikiamobileeditor-preview' )->text() );
		$this->response->setVal( 'publish', wfMessage( 'wikiamobileeditor-publish' )->text() );
		$this->response->setVal( 'keepEditing', wfMessage( 'wikiamobileeditor-keep-editing' )->text() );
		$this->response->setVal( 'summaryPlaceholder', wfMessage( 'wikiamobileeditor-summary-placeholder' )->escaped() );
		$this->response->setVal( 'licensing', wfMessage( 'wikiamobileeditor-licensing' )->text() );
		$this->response->setVal( 'licensingType', $this->wg->RightsText );
	}
}
