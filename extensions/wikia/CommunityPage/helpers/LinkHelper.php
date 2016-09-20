<?php

class LinkHelper {
	static $WITH_EDIT_MODE = true;
	static $WITHOUT_EDIT_MODE = false;

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
