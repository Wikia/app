<?php
class DesignSystemHooks {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system/dist';

	/**
	 * @desc Adds Design System styles to all Oasis pages
	 *
	 * @param OutputPage $out
	 * @param object $skin
	 *
	 * @return bool true
	 */
	public static function onBeforePageDisplay( $out, $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'design_system_scss' );

			if ( F::app()->wg->User->isLoggedIn() ) {
				\Wikia::addAssetsToOutput( 'design_system_user_scss' );
			}
		}

		return true;
	}
}
