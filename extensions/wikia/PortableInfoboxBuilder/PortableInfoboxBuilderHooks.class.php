<?php

class PortableInfoboxBuilderHooks {
	const INFOBOX_BUILDER_SPECIAL_PAGE = 'Special:InfoboxBuilder';

	/**
	 * Adds infobox builder helper js assets to Template Classification on Edit page
	 *
	 * @return true
	 */
	public static function onTCAfterEditPageAssets() {
		\Wikia::addAssetsToOutput( 'portable_infobox_builder_template_classification_helper_js' );

		return true;
	}

	/**
	 * @param Skin $skin
	 * @param string $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$title = $skin->getTitle();

		if ( $title && $title->isSpecial( PortableInfoboxBuilderSpecialController::PAGE_NAME ) ) {
			$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_builder_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		return true;
	}

	/**
	 * Add global variables for Javascript
	 * @param array $aVars
	 * @return bool
	 */
	public static function onEditPageMakeGlobalVariablesScript( array &$aVars ) {
		$context = \RequestContext::getMain();
		$title = $context->getTitle();
		if ( self::shouldPassInfoboxBuilderVars( $context ) ) {
			$aVars['isTemplateBodySupportedInfobox'] =
				( new \PortableInfoboxBuilderService() )->isValidInfoboxArray(
					\PortableInfoboxDataService::newFromTitle( $title )->getInfoboxes()
				);
			$aVars['tcBodyClassName'] = \Wikia\TemplateClassification\Hooks::TC_BODY_CLASS_NAME;
			$aVars['infoboxBuilderPath'] = \SpecialPage::getTitleFor( 'InfoboxBuilder', $title->getText() )
				->getFullURL();

		}
		return true;
	}

	/**
	 * Decide to display Infobox builder in VE
	 * @param array $aVars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( array &$aVars ) {
		global $wgEnablePortableInfoboxBuilderInVE, $wgEnableVisualEditorExt;

		if ( $wgEnableVisualEditorExt && \VisualEditorHooks::isAvailable( \RequestContext::getMain()->getSkin() ) ) {
			$aVars['wgEnablePortableInfoboxBuilderInVE'] = $wgEnablePortableInfoboxBuilderInVE &&
				\RequestContext::getMain()->getUser()->isAllowed( 'createpage' );
		}

		return true;
	}

	/**
	 *
	 * @param $page \Article|\Page
	 * @param $user \User
	 * @return bool
	 */
	public static function onCustomEditor( $page, $user ) {
		$title = $page->getTitle();
		$request = RequestContext::getMain()->getRequest();

		if (
			PortableInfoboxBuilderHelper::canUseInfoboxBuilder( $title, $user )
				&& !PortableInfoboxBuilderHelper::isSubmitAction( $request )
				&& !PortableInfoboxBuilderHelper::isForcedSourceMode( $request )
		) {
			$url = SpecialPage::getTitleFor( 'InfoboxBuilder', $title->getText() )->getInternalURL();
			F::app()->wg->out->redirect( $url );
			return false;
		}
		return true;

	}

	/**
	 * @param $context
	 * @return bool
	 */
	protected static function shouldPassInfoboxBuilderVars( $context ) {
		return ( new \Wikia\TemplateClassification\Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $context->getTitle() )
			&& \RequestContext::getMain()->getRequest()->getVal( 'action' ) === 'edit'
			&& !\PortableInfoboxBuilderHelper::isForcedSourceMode( $context->getRequest() );
	}
}
