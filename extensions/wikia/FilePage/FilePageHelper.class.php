<?

class FilePageHelper {

	public static $videoPageVideoWidth = 670;

	public static function stripCategoriesFromDescription( $content ) {
		// Strip out the category tags so they aren't shown to the user
		$content = preg_replace( '/\[\[Category[^\]]+\]\]/', '', $content );

		// If we have an empty string or a bunch of whitespace, return null
		if( trim($content) == "" ) {
			$content = null;
		}

		return $content;
	}

	public static function getVideoPageEmbedHTML( $file ) {
		$app = F::app();
		$autoplay = $app->wg->VideoPageAutoPlay;

		$imageLink = '<div class="fullImageLink" id="file">' . $file->getEmbedCode( self::$videoPageVideoWidth, $autoplay ) . '</div>';

		return $imageLink;
	}

	/**
	 * If a timestamp is specified, show the archived version of the video (if it exists)
	 *
	 * @param $timestamp Int
	 */
	public static function setVideoFromTimestamp( $timestamp, $title, &$file) {

		if ( $timestamp > 0 ) {
			$archiveFile = wfFindFile( $title, $timestamp );
			if ( $archiveFile instanceof LocalFile && $archiveFile->exists()) {
				$file = $archiveFile;
			}
		}

		return true;
	}

	/**
	 * @param $file File
	 * @return String Url where user can re-upload the file
	 */
	public static function getUploadUrl( $file ) {
		wfProfileIn( __METHOD__ );

		$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
		$name = $file->getName();
		$url = $uploadTitle->getFullUrl( array( 'name' => $name ) );

		wfProfileOut( __METHOD__ );

		return $url;
	}
}
