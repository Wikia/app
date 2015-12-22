<?php

class ThemeDesignerHooks {

	/**
	 * @param $revision Revision
	 * @return bool
	 */
	public static function onRevisionInsertComplete( $revision ) {
		wfProfileIn( __METHOD__ );

		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle( true );
			self::resetThemeBackgroundSettings( $title );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $article WikiPage
	 * @return bool true
	 */
	public static function onArticleDeleteComplete( $article ) {
		wfProfileIn( __METHOD__ );

		if ( $article instanceof WikiFilePage ) {
			$title = $article->getTitle();
			self::resetThemeBackgroundSettings( $title, true );
			if ( self::isFavicon( $title ) ) {
				Wikia::invalidateFavicon();
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $image UploadForm
	 * @return bool
	 */
	public static function onUploadComplete( $image ) {
		wfProfileIn( __METHOD__ );

		if ( self::isFavicon( $image->getTitle() ) ) {
			Wikia::invalidateFavicon();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Do not allow non-admins to upload wiki wordmark and background
	 *
	 * @param $destName string
	 * @param $tempPath string
	 * @param $error string
	 * @return bool return false to prevent the upload
	 */
	public static function onUploadVerification( $destName, $tempPath, &$error ) {
		$destName = strtolower($destName);
		if ( $destName == 'wiki-wordmark.png' || $destName == 'wiki-background' ) {
			// BugId:983
			$error = wfMessage( 'themedesigner-manual-upload-error' )->plain();
			return false;
		}
		return true;
	}

	public static function onBeforePageDisplay( $out, $skin ) {
		global $wgExtensionsPath;

		$out->addScript('<script src="'.$wgExtensionsPath.'/wikia/ThemeDesigner/js/BetterColor.js"></script>');

		return true;
	}

	/**
	 * @param $title Title
	 * @return bool
	 */
	private static function isFavicon( $title ) {
		wfProfileIn( __METHOD__ );
		if ( $title->getText() == 'Favicon.ico' ) {
			$isFavicon = true;
		} else {
			$isFavicon = false;
		}
		wfProfileOut( __METHOD__ );
		return $isFavicon;
	}

	/**
	 * @param $title Title
	 * @param bool $isArticleDeleted
	 */
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
