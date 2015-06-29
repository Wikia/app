<?php

/**
 * Hooks for LinkSuggest
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
class LinkSuggestHooks {

	/**
	 * @param User $user
	 * @param Array $preferences
	 * @return bool
	 */
	static function onGetPreferences($user, &$preferences) {
		$preferences['disablelinksuggest'] = array(
			'type' => 'toggle',
			'section' => 'editing/editing-experience',
			'label-message' => 'tog-disablelinksuggest',
		);
		return true;
	}

	/**
	 * @param $a
	 * @param $b
	 * @param $c
	 * @param $d
	 * @return bool
	 */
	static function onEditFormMultiEditForm($a, $b, $c, $d) {
		global $wgOut, $wgUser;

		if($wgUser->getGlobalPreference('disablelinksuggest') != true) {
			$wgOut->addModules( 'ext.wikia.LinkSuggest' );
		}

		return true;
	}
}
