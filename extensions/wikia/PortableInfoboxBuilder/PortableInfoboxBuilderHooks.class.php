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
}
