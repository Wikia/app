<?php

namespace Wikia\TemplateClassification;

use Swagger\Client\ApiException;
use Wikia\TemplateClassification\UnusedTemplates\Handler;
use Wikia\GlobalShortcuts\Helper;

class Hooks {
	const TC_BODY_CLASS_NAME = 'show-template-classification-modal';

	/**
	 * Register hooks for the extension
	 */
	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
		\Hooks::register( 'PageHeaderPageTypePrepared', [ $hooks, 'onPageHeaderPageTypePrepared' ] );
		\Hooks::register( 'QueryPageUseResultsBeforeRecache', [ $hooks, 'onQueryPageUseResultsBeforeRecache' ] );
		/* Edit page hooks */
		\Hooks::register( 'ArticleSaveComplete', [ $hooks, 'onArticleSaveComplete' ] );
		\Hooks::register( 'EditPage::showEditForm:fields', [ $hooks, 'onEditPageShowEditFormFields' ] );
		\Hooks::register( 'EditPageLayoutExecute', [ $hooks, 'onEditPageLayoutExecute' ] );
		\Hooks::register( 'EditPageMakeGlobalVariablesScript', [ $hooks, 'onEditPageMakeGlobalVariablesScript' ] );
		\Hooks::register( 'SkinTemplateNavigation', [ $hooks, 'onSkinTemplateNavigation' ] );
		\Hooks::register( 'PageHeaderDropdownActions', [ $hooks, 'onPageHeaderDropdownActions' ] );
	}

	/**
	 * Save template type passed from article creation
	 * changed template type is stored in templateClassificationTypeNew hidden field.
	 * Previous type is stored in templateClassificationTypeCurrent.
	 *
	 * @param \WikiPage $wikiPage
	 * @param \User $user
	 * @return bool
	 */
	public function onArticleSaveComplete( \WikiPage $article, \User $user, $text, $summary,
		$minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId
	) {
		global $wgCityId;

		$request = \RequestContext::getMain()->getRequest();
		$typeNew = $request->getVal( 'templateClassificationTypeNew' );
		$typeCurrent = $request->getVal( 'templateClassificationTypeCurrent' );

		/**
		 * The service was not available when the field's value was set
		 * so we exit early to prevent polluting of the results.
		 */
		if ( empty( $typeNew )
			 || $typeNew === \TemplateClassificationService::NOT_AVAILABLE
			 || $typeNew === $typeCurrent
		) {
			return true;
		}

		try {
			( new \UserTemplateClassificationService() )->classifyTemplate(
				$wgCityId,
				$article->getId(),
				$typeNew,
				$user->getId()
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
		$title = $context->getTitle();
		// Enable TemplateClassificationEditorPlugin
		if ( ( new Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $title )
			 && $this->isEditPage()
		) {
			$aVars[ 'enableTemplateClassificationEditorPlugin' ] = true;
		}
		return true;
	}

	/**
	 * Add hidden input to editform with template type
	 * @param \EditPage $editPage
	 * @param \OutputPage $out
	 * @return bool
	 */
	public function onEditPageShowEditFormFields( \EditPage $editPage, \OutputPage $out ) {
		global $wgCityId;

		$context = \RequestContext::getMain();
		$title = $context->getTitle();

		if ( ( new Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $title ) ) {
			$types = $this->getTemplateTypeForEdit( $editPage->getTitle(), $wgCityId );

			$out->addHTML( \Html::hidden( 'templateClassificationTypeCurrent', $types[ 'current' ],
				[ 'autocomplete' => 'off' ] ) );
			$out->addHTML( \Html::hidden( 'templateClassificationTypeNew', $types[ 'new' ],
				[ 'autocomplete' => 'off' ] ) );

			// add additional class to body for new templates in order to hide editor while template classification
			// modal is visible and builder is available
			if ( $this->shouldHideEditorForInfoboxBuilder( $context, $types ) ) {
				\OasisController::addBodyClass( self::TC_BODY_CLASS_NAME );
			}
		}

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
		global $wgEnableGlobalShortcutsExt;
		$title = $out->getTitle();
		$user = $skin->getUser();
		$permissions = new Permissions();

		if ( $permissions->shouldDisplayEntryPoint( $user, $title ) ) {
			if ( $title->exists() && !$this->isEditPage() ) {
				\Wikia::addAssetsToOutput( 'template_classification_in_view_js' );
				\Wikia::addAssetsToOutput( 'template_classification_scss' );
				if ( !empty( $wgEnableGlobalShortcutsExt ) && Helper::shouldDisplayGlobalShortcuts() ) {
					\Wikia::addAssetsToOutput( 'template_classification_globalshortcuts_js' );
				}
			} elseif ( $this->isEditPage() ) {
				\Wikia::addAssetsToOutput( 'template_classification_in_edit_js' );
				\Wikia::addAssetsToOutput( 'template_classification_scss' );

				wfRunHooks( 'TemplateClassificationHooks::afterEditPageAssets' );
			}
		} elseif ( $permissions->shouldDisplayBulkActions( $user, $title ) ) {
			\Wikia::addAssetsToOutput( 'template_classification_in_category_js' );
			\Wikia::addAssetsToOutput( 'template_classification_scss' );
			if ( !empty( $wgEnableGlobalShortcutsExt ) && Helper::shouldDisplayGlobalShortcuts() ) {
				\Wikia::addAssetsToOutput( 'template_classification_globalshortcuts_js' );
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
	public function onQueryPageUseResultsBeforeRecache( \QueryPage $queryPage, \DatabaseBase $db, $results ) {
		if ( $queryPage->getName() === \UnusedtemplatesPage::UNUSED_TEMPLATES_PAGE_NAME ) {
			$handler = $this->getUnusedTemplatesHandler();
			if ( $results instanceof \ResultWrapper ) {
				$handler->markAsUnusedFromResults( $results );
				$db->dataSeek( $results, 0 );    // CE-3024: reset cursor because hook caller needs the results also
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
			$editPage->addExtraHeaderHtml(
				( new View )->renderTemplateType( $wgCityId, $title, $user )
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

	/**
	 * Retrieves template type for edit page purposes
	 * Has fallback to infobox when in template draft conversion process
	 * @param \Title $title
	 * @param int $wikiaId
	 * @return array
	 */
	private function getTemplateTypeForEdit( \Title $title, $wikiaId ) {
		global $wgEnableTemplateDraftExt;

		$types = [
			'current' => '',
			'new' => ''
		];

		if ( !empty( $wgEnableTemplateDraftExt )
			 && \TemplateDraftHelper::isInfoboxDraftConversion( $title )
		) {
			$types[ 'new' ] = \TemplateClassificationService::TEMPLATE_INFOBOX;
		} else {
			try {
				$types[ 'current' ] = ( new \UserTemplateClassificationService() )->getType( $wikiaId, $title->getArticleID() );
			} catch ( ApiException $e ) {
				( new Logger() )->exception( $e );
				/**
				 * If the service is unreachable - fill the field with a not-available string
				 * which instructs front-end tools to skip the classification part.
				 */
				$types[ 'current' ] = \TemplateClassificationService::NOT_AVAILABLE;
			}
		}

		return $types;
	}

	/**
	 * Prepare bulk template classification action and adds to possible action links.
	 *
	 * @param \Skin $skin
	 * @param $links
	 * @return bool
	 */
	public function onSkinTemplateNavigation( \Skin $skin, &$links ) {
		if ( ( new Permissions() )->shouldDisplayBulkActions( $skin->getUser(), $skin->getTitle() ) ) {
			$links[ 'views' ][ 'bulk-classification' ] = [
				'href' => '#',
				'text' => wfMessage( 'template-classification-edit-modal-title-bulk-types' )->escaped(),
				'class' => 'template-classification-type-text',
			];
		}

		return true;
	}

	/**
	 * Add bulk template classification action to dropdown.
	 * If this action not exists (@see onSkinTemplateNavigation) will be omitted.
	 *
	 * @param array $actions
	 * @return bool
	 */
	public function onPageHeaderDropdownActions( array &$actions ) {
		$actions[] = 'bulk-classification';

		return true;
	}

	/**
	 * @param \RequestContext $context
	 * @param $types
	 * @return bool
	 */
	private function shouldHideEditorForInfoboxBuilder( \RequestContext $context, $types ) {
		global $wgEnablePortableInfoboxBuilderExt;

		return $wgEnablePortableInfoboxBuilderExt
			   && $context->getTitle()->getArticleID() === 0
			   && empty( $types[ 'current' ] )
			   && empty( $types[ 'new' ] )
			   && !\PortableInfoboxBuilderHelper::isForcedSourceMode( $context->getRequest() );
	}
}
