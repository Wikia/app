<?php

namespace Wikia\TemplateClassification;

use Wikia\TemplateClassification\Permissions;
use Wikia\TemplateClassification\UnusedTemplates\Handler;

class Hooks {

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
		\Hooks::register( 'PageHeaderPageTypePrepared', [ $hooks, 'onPageHeaderPageTypePrepared' ] );
		\Hooks::register( 'QueryPageUseResultsBeforeRecache', [ $hooks, 'onQueryPageUseResultsBeforeRecache' ] );
		\Hooks::register( 'EditPageLayoutExecute', [ $hooks, 'onEditPageLayoutExecute' ] );
	}

	/**
	 * Adds assets for TemplateClassification
	 *
	 * @param \OutputPage $out
	 * @param \Skin $skin
	 *
	 * @return true
	 */
	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $skin->getUser(), $out->getTitle() ) ) {
			\Wikia::addAssetsToOutput( 'tempate_classification_js' );
			\Wikia::addAssetsToOutput( 'tempate_classification_scss' );
		}
		return true;
	}

	/**
	 * @param \PageHeaderController $pageHeaderController
	 * @param \Title $title
	 * @return bool
	 */
	public function onPageHeaderPageTypePrepared( \PageHeaderController $pageHeaderController, \Title $title ) {
		$user = $pageHeaderController->getContext()->getUser();
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $user, $title ) ) {
			$view = new View();
			$pageHeaderController->pageType = $view->renderTemplateType(
				$title->getArticleID(), $user, $pageHeaderController->pageType
			);
		}
		return true;
	}

	/**
	 * @param \QueryPage $queryPage
	 * @param $results
	 * @return bool
	 */
	public function onQueryPageUseResultsBeforeRecache( \QueryPage $queryPage, $results ) {
		if ( $queryPage->getName() === \UnusedtemplatesPage::UNUSED_TEMPLATES_PAGE_NAME ) {
			$handler = $this->getUnusedTemplatesHandler();
			if ( $results instanceof \ResultWrapper ) {
				$handler->markAsUnusedFromResults( $results );
			} else {
				$handler->markAllAsUsed();
			}
		}
		return true;
	}

	/**
	 * @param \EditPageLayoutController $editPage
	 * @return bool
	 */
	public function onEditPageLayoutExecute( \EditPageLayoutController $editPage ) {
		$user = $editPage->getContext()->getUser();
		$title = $editPage->getContext()->getTitle();
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $user, $title ) ) {
			$editPage->addExtraPageControlsHtml(
				( new View )->renderEditPageEntryPoint( $title->getArticleID(), $user )
			);
		}
		return true;
	}

	/**
	 * @return Handler
	 */
	protected function getUnusedTemplatesHandler() {
		return new Handler();
	}
}
