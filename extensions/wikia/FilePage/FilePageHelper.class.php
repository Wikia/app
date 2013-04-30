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

	public static function getVideoPageVideoEmbedHTML( $file ) {
		$app = F::app();
		$autoplay = $app->wg->VideoPageAutoPlay;

		$imageLink = '<div class="fullImageLink" id="file">' . $file->getEmbedCode( self::$videoPageVideoWidth, $autoplay ) . '</div>';

		return $imageLink;
	}

	public static function getVideosCategory() {
		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return ucfirst($cat) . ':' . wfMsgForContent( 'videohandler-category' );
	}


}
