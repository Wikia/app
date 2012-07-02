<?php
/**
 * @file
 * @author William Lee <wlee@wikia-inc.com>
 * @see http://trac.wikia-code.com/changeset/38530
 */
class HuluVideoProvider extends BaseVideoProvider {
	protected $embedTemplate = '<object width="$width" height="$height"><param name="movie" value="$video_id"></param><param name="allowFullScreen" value="true"></param><embed src="$video_id" type="application/x-shockwave-flash"  width="$width" height="$height" allowFullScreen="true"></embed></object>';

	public static function getDomains() {
		return array( 'hulu.com' );
	}

	protected function getRatio() {
		return 512 / 296;
	}

	protected function extractVideoId( $url ) {
		global $wgMemc;

		if ( !preg_match( '#/watch/(?<id>\d+)/#', $url, $matches) ) {
			return null;
		}

		$videoId = $matches['id'];

		$cacheKey = wfMemcKey( 'video', 'hulu', $videoId );
		$cachedEmbedId = $wgMemc->get( $cacheKey );

		if ( $cachedEmbedId !== false ) {
			return $cachedEmbedId;
		}

		$apiUrl = 'http://www.hulu.com/api/oembed.json?url=' . urlencode( $url );
		$apiResult = Http::get( $apiUrl );

		if ( $apiResult === false ) {
			return null;
		}

		$apiResult = FormatJson::decode( $apiResult, true );
		$embedId = $apiResult['embed_url'];

		$wgMemc->set( $cacheKey, $embedId, 60 * 60 * 24 );

		return $embedId;
	}
}