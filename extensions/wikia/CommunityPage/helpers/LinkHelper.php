<?php

class LinkHelper {
	public static function forceLoginLink(Title $title, $edit=true ) {
		global $wgUser, $wgDisableAnonymousEditing;

		if ( $wgDisableAnonymousEditing && !$wgUser->isLoggedIn() ) {
			return SpecialPage::getTitleFor( 'SignUp' )->getFullURL(
				$query2=[
					'returnto' => $title->getEscapedText(),
					'returntoquery' => $edit ? self::getEditorParam() : '',
					'type' => 'login'
				]);
		}

		return $edit ? static::getEditUrl( $title->getFullURL() ) : $title->getFullURL();
	}

	public static function getEditUrl( $articleUrl ) {
		return $articleUrl . '?'. static::getEditorParam();
	}

	private static function getEditorParam() {
		if ( EditorPreference::isVisualEditorPrimary() ) {
			return 'veaction=edit';
		}
		return 'action=edit';
	}
}