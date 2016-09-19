<?php

class LinkHelper {
	public static function getEditUrl( Title $article ) {
		global $wgUser, $wgDisableAnonymousEditing;

		if ( $wgDisableAnonymousEditing ) {
			 if ( $wgUser->isLoggedIn() ) {
				 return static::editUrl( $article->getFullURL() );
			 } else {
			 	return SpecialPage::getTitleFor( 'SignUp' )->getFullURL(
			 		$query2=[
			 			'returnto' => $article->getEscapedText(),
						'returntoquery' => self::getEditorParam(),
						'type' => 'login'
				]);
			 }
		} else {
			return static::editUrl( $article->getFullURL() );
		}
	}

	private static function editUrl( $articleUrl ) {
		return $articleUrl . '?'. static::getEditorParam();
	}

	private static function getEditorParam() {
		if ( EditorPreference::isVisualEditorPrimary() ) {
			return 'veaction=edit';
		}
		return 'action=edit';
	}
}