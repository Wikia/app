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
		/* Edit page hooks */
		\Hooks::register( 'EditPage::showEditForm:fields', [ $hooks, 'onEditPageShowEditFormFields' ] );
		\Hooks::register( 'ArticleInsertComplete', [ $hooks, 'onArticleInsertComplete' ] );
		\Hooks::register( 'EditPageLayoutExecute', [ $hooks, 'onEditPageLayoutExecute' ] );
		\Hooks::register( 'EditPageMakeGlobalVariablesScript', [ $hooks, 'onEditPageMakeGlobalVariablesScript' ] );
	}

	/**
	 * Save template type passed from article creation
	 * template type is stored in templateClassificationType hidden field
	 *
	 * @param \WikiPage $wikiPage
	 * @return bool
	 */
	public function onArticleInsertComplete( \WikiPage $wikiPage ) {
		( new \TemplateClassificationMockService() )->setTemplateType(
			$wikiPage->getId(),
			\RequestContext::getMain()->getRequest()->getVal('templateClassificationType')
		);
		return true;
	}

	/**
	 * Add global variables for Javascript
	 * @param array $aVars
	 * @return bool
	 */
	public function onEditPageMakeGlobalVariablesScript( array &$aVars ) {
		$context = \RequestContext::getMain();

		// Enable TemplateClassificationEditorPlugin
		if ( ( new Permissions() )->shouldDisplayEntryPointInEdit( $context->getUser(), $context->getTitle() ) ) {
			$aVars['enableTemplateClassificationEditorPlugin'] = true;
		}
		return true;
	}

	/**
	 * Add hidden input to editform with template type
	 * @param \EditPageLayout $editPage
	 * @param \OutputPage $out
	 */
	public static function onEditPageShowEditFormFields( \EditPageLayout $editPage, \OutputPage $out ) {
		return true;
		$articleId = $editPage->getTitle()->getArticleID();
		$templateType = ( new \TemplateClassificationMockService() )->getTemplateType( $articleId );
		$editPage->addHiddenField([
			'name' => 'templateClassificationType',
			'value' => $templateType,
			'type' => 'hidden',
		]);

		return true;
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
		$permissions = new Permissions();
		if ( $permissions->shouldDisplayEntryPointOnView( $skin->getUser(), $out->getTitle() ) ) {
			\Wikia::addAssetsToOutput( 'template_classification_js' );
			\Wikia::addAssetsToOutput( 'template_classification_scss' );
		} elseif ( $permissions->shouldDisplayEntryPointInEdit( $skin->getUser(), $out->getTitle() ) ) {
			\Wikia::addAssetsToOutput( 'template_classification_js' );
			\Wikia::addAssetsToOutput( 'template_classification_scss' );
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
		if ( ( new Permissions() )->shouldDisplayTypeLabel( $title ) ) {
			$view = new View();
			$pageHeaderController->pageType = $view->renderTemplateType(
				$title, $user, $pageHeaderController->pageType
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
				( new View )->renderEditPageEntryPoint( $title, $user )
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
