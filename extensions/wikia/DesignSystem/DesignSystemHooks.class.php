<?php
class DesignSystemHooks {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/node_modules/design-system/dist';

	/**
	 * @desc Adds Design System styles to all pages
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 *
	 * @return bool true
	 */
	public static function onBeforePageDisplay( $out, $skin ) {
		\Wikia::addAssetsToOutput( 'design_system_scss' );
		\Wikia::addAssetsToOutput( 'search_tracking_js' );

		if ( $skin->getUser()->isLoggedIn() ) {
			\Wikia::addAssetsToOutput( 'design_system_user_scss' );
		}

		$out->addModules( 'ext.designSystem' );
		return true;
	}
}
