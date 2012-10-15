<?php

class ViddlerVideoProvider extends BaseVideoProvider {
	const idRegex = '#src="http://www\.viddler\.com/player/(?<id>[a-zA-Z0-9]*?)/"#';
	protected $embedTemplate = '<object width="$width" height="$height" id="viddlerplayer-$video_id"><param name="movie" value="http://www.viddler.com/player/$video_id/" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="transparent" /><param name="allowFullScreen" value="true" /><embed src="http://www.viddler.com/player/$video_id/" width="$width" height="$height" type="application/x-shockwave-flash" wmode="transparent" allowScriptAccess="always" allowFullScreen="true" name="viddlerplayer-$video_id" ></embed></object>';

	public static function getDomains() {
		return array( 'viddler.com' );
	}

	protected function getRatio() {
		return 437 / 288;
	}


	protected function extractVideoId( $url ) {
		global $wgMemc;

		$cacheKey = wfMemcKey( 'video', 'viddler', sha1( $url ) );
		$cachedEmbedId = $wgMemc->get( $cacheKey );

		if ( $cachedEmbedId !== false ) {
			return $cachedEmbedId;
		}

		$apiUrl = 'http://lab.viddler.com/services/oembed/?format=json&url=' . urlencode( $url );
		$apiResult = HTTP::get( $apiUrl );

		if ( $apiResult === false ) {
			return null;
		}

		$apiResult = FormatJson::decode( $apiResult, true );

		// Extract the player source from the HTML
		if ( !preg_match( self::idRegex, $apiResult['html'], $matches ) ) {
			return null;
		}

		$embedId = $matches['id'];

		$wgMemc->set( $cacheKey, $embedId, 60 * 60 * 24 );

		return $embedId;
	}
}