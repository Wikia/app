<?php
/**
 *
 * @author Bartłomiej Kowalczyk
 */

class AuthModalHooks {

	/**
	 * Adds assets for BannerNotifications on the bottom of the body on Monobook
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return true
	 */
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'auth_modal_scss' );
			\Wikia::addAssetsToOutput( 'auth_modal_js' );
		}

		return true;
	}
}
