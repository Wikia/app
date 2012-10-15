<?php
/**
 * Hooks for DontSwitchMeOver extension
 *
 * @file
 * @ingroup Extensions
 */

class DontSwitchMeOverHooks {
	
	/* Static Methods */
	
	/**
	 * GetPreferences hook
	 */
	public static function getPreferences( $user, &$defaultPreferences ) {
		$defaultPreferences['dontswitchmeover'] = array(
			'type' => 'toggle',
			'label-message' => 'dontswitchmeover-pref',
			'section' => 'rendering/skin',
		);
		return true;
	}
}
