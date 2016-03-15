<?php

class PortableInfoboxBuilderHooks {
	const INFOBOX_BUILDER_SPECIAL_PAGE = 'Special:InfoboxBuilder';


	/**
	 * Adds infobox builder helper js assets to Template Classification on Edit page
	 *
	 * @return true
	 */
	public function onTCAfterEditPageAssets() {
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
	 * Hook that exports url to the current template page
	 *
	 * @param Array $vars - (reference) js variables
	 * @param Array $scripts - (reference) js scripts
	 * @param Skin $skin - skins
	 * @return Boolean True - to continue hooks execution
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts, $skin ) {
		$title = $skin->getTitle();

		if ( $title && $title->isSpecial( PortableInfoboxBuilderSpecialController::PAGE_NAME ) ) {
			$templateTitleText = PortableInfoboxBuilderHelper::getUrlPath( $title->getText() );

			// We need the variable only if Infobox Builder launches (there is a template title provided)
			if ( $templateTitleText ) {
				$templateTitle = Title::newFromText( $templateTitleText, NS_TEMPLATE );
				$vars['templatePageUrl'] = $templateTitle->getFullUrl();
				$vars['sourceEditorUrl'] = $templateTitle->getFullUrl( [
					'action' => 'edit',
					'useeditor' => 'source'
				] );
			}
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
	 *
	 * @param $page \Article|\Page
	 * @param $user \User
	 * @return bool
	 */
	public static function onCustomEditor( $page, $user ) {
		$title = $page->getTitle();

		if (
			PortableInfoboxBuilderHelper::canUseInfoboxBuilder( $title, $user )
			&& !PortableInfoboxBuilderHelper::isForcedSourceMode( RequestContext::getMain()->getRequest() )
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
	protected function shouldPassInfoboxBuilderVars( $context ) {
		return ( new \Wikia\TemplateClassification\Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $context->getTitle() ) && \RequestContext::getMain()->getRequest()->getVal( 'action' ) === 'edit' && !\PortableInfoboxBuilderHelper::isForcedSourceMode( $context->getRequest() );
	}
}
