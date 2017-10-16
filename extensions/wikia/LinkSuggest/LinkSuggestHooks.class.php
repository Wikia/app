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
		$preferences['disablelinksuggest'] = [
			'type' => 'toggle',
			'section' => 'editing/editing-experience',
			'label-message' => 'tog-disablelinksuggest',
		];
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
		LinkSuggestLoader::getInstance()->addSelectors( '#wpTextbox1' );
		return true;
	}

	/**
	 * Hook: UploadForm:Initial
	 * VOLDEV-121: Add LinkSuggest to Special:Upload and MultipleUpload
	 * @author TK-999
	 * @param SpecialUpload|SFUploadWindow $specialUpload
	 * @return bool true because it's a hook
	*/
	public static function onUploadFormInitial( $specialUpload ) {
		LinkSuggestLoader::getInstance()->addSelectors( '#wpUploadDescription' );
		return true;
	}
}
