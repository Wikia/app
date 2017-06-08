<?php

class ThemeDesignerHooks {

	/**
	 * @param $revision Revision
	 * @return bool
	 */
	public static function onRevisionInsertComplete( $revision ) {

		if ( $revision instanceof Revision ) {
			$title = $revision->getTitle( true );
			self::resetThemeBackgroundSettings( $title );
		}

		return true;
	}

	/**
	 * @param $article WikiPage
	 * @return bool true
	 */
	public static function onArticleDeleteComplete( $article ) {

		if ( $article instanceof WikiFilePage ) {
			$title = $article->getTitle();
			self::resetThemeBackgroundSettings( $title, true );
			if ( self::isFavicon( $title ) ) {
				Wikia::invalidateFavicon();
			}
		}

		return true;
	}

	/**
	 * @param $image UploadForm
	 * @return bool
	 */
	public static function onUploadComplete( $image ) {

		if ( self::isFavicon( $image->getTitle() ) ) {
			Wikia::invalidateFavicon();
		}

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
		$destName = strtolower( $destName );

		if (
			$destName == strtolower( ThemeSettings::WordmarkImageName ) ||
			$destName == strtolower( ThemeSettings::BackgroundImageName ) ||
			$destName == strtolower( ThemeSettings::CommunityHeaderBackgroundImageName )
		) {
			// BugId:983
			$error = wfMessage( 'themedesigner-manual-upload-error' )->escaped();

			return false;
		}

		return true;
	}

	/**
	 * @param $title Title
	 * @return bool
	 */
	private static function isFavicon( Title $title ): bool {
		return $title->getText() == 'Favicon.ico';
	}

	/**
	 * @param Title $title
	 * @param bool $isArticleDeleted
	 */
	private static function resetThemeBackgroundSettings( $title, $isArticleDeleted = false ) {

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
	}
}
