<?php

class PortableInfoboxBuilderHooks {
	const INFOBOX_BUILDER_SPECIAL_PAGE = 'Special:InfoboxBuilder';

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
			// remove the special page name from the title and return url to the template
			// passed after the slash, i.e.
			// Special:InfoboxBuilder/TemplateName/Subpage => Template:TemplateName/Subpage
			$vars['templatePageUrl'] = Title::newFromText(
				implode( '/', array_slice( explode( '/', $title->getText() ), 1 ) ),
				NS_TEMPLATE )->getFullUrl();
		}

		return true;
	}
}
