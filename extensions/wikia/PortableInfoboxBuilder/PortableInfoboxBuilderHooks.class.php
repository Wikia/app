<?php

class PortableInfoboxBuilderHooks {
	const QUERYSTRING_EDITOR_KEY = 'useeditor';
	const INFOBOX_BUILDER_SPECIAL_PAGE = 'Special:InfoboxBuilder';
	const QUERYSTRING_SOURCE_MODE = 'source';

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
			$templateTitleText = self::getUrlPath( $title->getText() );

			// We need the variable only if Infobox Builder launches (there is a template title provided)
			if ( $templateTitleText ) {
				$templateTitle = Title::newFromText( $templateTitleText, NS_TEMPLATE );
				$vars['templatePageUrl'] = $templateTitle->getFullUrl();
			}
		}

		return true;
	}

	/**
	 * remove the special page name from the title and return name of the template
	 * passed after the slash without the namespace, i.e.
	 * Special:InfoboxBuilder/TemplateName/Subpage => TemplateName/Subpage
	 * @param $titleText
	 * @return string
	 */
	private static function getUrlPath( $titleText ) {
		return implode( '/', array_slice( explode( '/', $titleText ), 1 ) );
	}

	/**
	 * Add global variables for Javascript
	 * @param array $aVars
	 * @return bool
	 */
	public function onEditPageMakeGlobalVariablesScript( array &$aVars ) {
		$context = \RequestContext::getMain();
		$title = $context->getTitle();
		if (
			( new \Wikia\TemplateClassification\Permissions() )->shouldDisplayEntryPoint( $context->getUser(), $title )
			&& \RequestContext::getMain()->getRequest()->getVal( 'action' ) === 'edit'
		) {
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
			self::canUseInfoboxBuilder( $title, $user )
			&& !self::isForcedSourceMode( RequestContext::getMain()->getRequest() )
		) {
			$url = SpecialPage::getTitleFor( 'InfoboxBuilder', $title->getText() )->getInternalURL();
			F::app()->wg->out->redirect( $url );
			return false;
		}
		return true;

	}

	/**
	 * @param $title
	 * @return bool
	 */
	private static function isInfoboxTemplate( $title ) {
		$tc = new TemplateClassificationService();
		$isInfobox = false;

		try {
			$type = $tc->getType( F::app()->wg->CityId, $title->getArticleID() );
			$isInfobox = ( $type === TemplateClassificationService::TEMPLATE_INFOBOX );
		} catch ( Swagger\Client\ApiException $e ) {
			// If we cannot reach the service assume the default (false) to avoid overwriting data
		}
		return $isInfobox;
	}

	/**
	 * @param $request WebRequest
	 * @return bool
	 */
	private static function isForcedSourceMode( $request ) {
		return ( $request->getVal( self::QUERYSTRING_EDITOR_KEY ) === self::QUERYSTRING_SOURCE_MODE );
	}

	/**
	 * @param $user
	 * @param $title
	 * @return bool
	 */
	private static function canUseInfoboxBuilder( $title, $user ) {
		return self::isInfoboxTemplate( $title )
		&& ( new \PortableInfoboxBuilderService() )->isValidInfoboxArray(
			\PortableInfoboxDataService::newFromTitle( $title )->getInfoboxes()
		)
		&& ( new \Wikia\TemplateClassification\Permissions() )->userCanChangeType( $user, $title );
	}
}
