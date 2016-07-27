<?php
class DesignSystemHooks {

	/**
	 * @desc Adds Design System styles to all Oasis pages
	 *
	 * @param OutputPage $out
	 *
	 * @return bool true
	 */
	public static function onBeforePageDisplay( $out, &$skin ) {

		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'design_system_scss' );
		}

		return true;
	}
}
