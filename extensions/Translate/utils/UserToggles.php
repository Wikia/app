<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class TranslatePreferences {
	/**
	 * Add toggle in Special:Preferences for opt-out on newsletter
	 */
	static function TranslateUserToggles( &$extraToggles ) {
		wfLoadExtensionMessages( 'Translate' );

		// 'tog-translate-nonewsletter' is used as opt-out for
		// users with a confirmed e-mail address
		$extraToggles[] = 'translate-nonewsletter';

		return true;
	}
}
