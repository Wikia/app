<?php

class ThemeDesignerHooks {
	public static function onRevisionInsertComplete( $revision ) {
		wfProfileIn( __METHOD__ );

		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle( true );
			self::resetThemeBackgroundSettings( $title );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onArticleDeleteComplete( $article ) {
		wfProfileIn( __METHOD__ );

		if ( $article instanceof WikiFilePage ) {
			$title = $article->getTitle();
			self::resetThemeBackgroundSettings( $title, true );
			self::checkFavicon( $title );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public static function onUploadComplete( $image ) {
		wfProfileIn( __METHOD__ );

		self::checkFavicon( $image->getTitle() );

		wfProfileOut( __METHOD__ );
		return true;
	}

	private static function checkFavicon( $title ) {
		wfProfileIn( __METHOD__ );
		if ( $title->getText() == 'Favicon.ico' ) {
			Wikia::uncacheFavicon();
		}
		wfProfileOut( __METHOD__ );
	}

	private static function resetThemeBackgroundSettings( $title, $isArticleDeleted = false ) {
		wfProfileIn( __METHOD__ );

		if ( $title instanceof Title && $title->getText() == ThemeSettings::BackgroundImageName ) {
			$themeSettings = new ThemeSettings();
			$settings = $themeSettings->getSettings();
			if ( strpos( $settings['background-image'], ThemeSettings::BackgroundImageName ) !== false ) {
				$settings['background-image-width'] = null;
				$settings['background-image-height'] = null;
				if ( $isArticleDeleted ) {
					$settings['background-image'] = '';
					$settings['user-background-image'] = '';
					$settings['user-background-image-thumb'] = '';
				}
			}
			$themeSettings->saveSettings( $settings );
		}

		wfProfileOut( __METHOD__ );
	}
}
