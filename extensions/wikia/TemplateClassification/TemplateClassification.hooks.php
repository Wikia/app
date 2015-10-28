<?php

namespace Wikia\TemplateClassification;

use Swagger\Client\ApiException;
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
		global $wgCityId;

		$request = \RequestContext::getMain()->getRequest();
		$type = $request->getVal( 'templateClassificationType' );

		/**
		 * The service was not available when the field's value was set
		 * so we exit early to prevent polluting of the results.
		 */
		if ( $type === \TemplateClassificationService::NOT_AVAILABLE ) {
			return true;
		}

		try {
			( new \TemplateClassificationService() )->classifyTemplate(
				$wgCityId,
				$wikiPage->getId(),
				$type,
				\TemplateClassificationService::USER_PROVIDER,
				$wikiPage->getUser()
			);
		} catch ( ApiException $e ) {
			( new Logger() )->exception( $e );
			\BannerNotificationsController::addConfirmation(
				wfMessage( 'template-classification-notification-error-retry' )->escaped(),
				\BannerNotificationsController::CONFIRMATION_WARN
			);
		}
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
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $context->getTitle() )
			&& $this->isEditPage()
		) {
			$aVars['enableTemplateClassificationEditorPlugin'] = true;
		}
		return true;
	}

	/**
	 * Add hidden input to editform with template type
	 * @param \EditPage $editPage
	 * @param \OutputPage $out
	 * @return bool
	 */
	public static function onEditPageShowEditFormFields( \EditPage $editPage, \OutputPage $out ) {
		global $wgCityId;

		if ( $out->getSkin() instanceof \SkinMonoBook ) {
			return true;
		}

		$articleId = $editPage->getTitle()->getArticleID();

		try {
			$templateType = ( new \TemplateClassificationService() )->getType( $wgCityId, $articleId );
		} catch ( ApiException $e ) {
			( new Logger() )->exception( $e );
			/**
			 * If the service is unreachable - fill the field with a not-available string
			 * which instructs front-end tools to skip the classification part.
			 */
			$templateType = \TemplateClassificationService::NOT_AVAILABLE;
		}

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
		$title = $out->getTitle();
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $skin->getUser(), $title ) ) {
			if ( $title->exists() ) {
				\Wikia::addAssetsToOutput( 'template_classification_in_view_js' );
				\Wikia::addAssetsToOutput( 'template_classification_scss' );
			} elseif ( $this->isEditPage() ) {
				\Wikia::addAssetsToOutput( 'template_classification_in_edit_js' );
				\Wikia::addAssetsToOutput( 'template_classification_scss' );
			}
		}
		return true;
	}

	/**
	 * @param \PageHeaderController $pageHeaderController
	 * @param \Title $title
	 * @return bool
	 */
	public function onPageHeaderPageTypePrepared( \PageHeaderController $pageHeaderController, \Title $title ) {
		global $wgCityId;

		$user = $pageHeaderController->getContext()->getUser();
		if ( $title->inNamespace( NS_TEMPLATE ) && $title->exists() ) {
			$view = new View();
			$pageHeaderController->pageType = $view->renderTemplateType(
				$wgCityId, $title, $user, $pageHeaderController->pageType
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
		global $wgCityId;

		$user = $editPage->getContext()->getUser();
		$title = $editPage->getContext()->getTitle();
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $user, $title ) ) {
			$editPage->addExtraPageControlsHtml(
				( new View )->renderEditPageEntryPoint( $wgCityId, $title, $user )
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

	private function isEditPage() {
		return \RequestContext::getMain()->getRequest()->getVal( 'action' ) === 'edit';
	}
}
