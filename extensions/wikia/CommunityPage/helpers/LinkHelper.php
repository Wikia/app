<?php

class LinkHelper {
	static $WITH_EDIT_MODE = true;
	static $WITHOUT_EDIT_MODE = false;

	/**
	 * Returns url to Special:SignUp with redirect to given article if current wiki has disabled anon edits and current
	 * user is anon. Otherwise link to given article is returned
	 *
	 * @param Title $title
	 * @param $editMode - if $WITH_EDIT_MODE then action=edit or veaction=edit is added to link (depending on which
	 * editor is primary).
	 * @return String - the url
	 */
	public static function forceLoginLink( Title $title, $editMode ) {
		global $wgUser, $wgDisableAnonymousEditing;

		if ( $wgDisableAnonymousEditing && !$wgUser->isLoggedIn() ) {
			return SpecialPage::getTitleFor( 'SignUp' )->getFullURL(
				[
					'returnto' => $title->getEscapedText(),
					'returntoquery' => $editMode ? urlencode( static::getEditorParam() ) : '',
					'type' => 'login'
				]);
		}

		return $editMode ?  $title->getFullURL() . '?' . static::getEditorParam() : $title->getFullURL();
	}

	private static function getEditorParam() {
		if ( EditorPreference::isVisualEditorPrimary() ) {
			return 'veaction=edit';
		}

		return 'action=edit';
	}
}
