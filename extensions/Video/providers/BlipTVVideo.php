<?php
/**
 * @file
 */
class BlipTVVideoProvider extends BaseVideoProvider {
	protected $embedTemplate = '<iframe src="http://blip.tv/play/$video_id.html" width="$width" height="$height" frameborder="0" allowfullscreen></iframe>';

	public static function getDomains() {
		return array( 'blip.tv' );
	}

	protected function getRatio() {
		return 480 / 350;
	}
	
	protected function extractVideoId( $url ) {
		global $wgMemc;

		// See if this is a valid url
		if ( !preg_match( '#/[a-zA-Z0-9\-]+/[a-zA-Z0-9\-]*-(\d+)#', $url, $matches ) ) {
			return null;
		}

		$videoId = $matches[1];

		$cacheKey = wfMemcKey( 'video', 'bliptv', $videoId );
		$cachedEmbedId = $wgMemc->get( $cacheKey );

		if ( $cachedEmbedId !== false ) {
			return $cachedEmbedId;
		}

		list( $apiUrl ) = explode( '?', $url);
		$apiUrl .= '?skin=api';

		$apiContents = Http::get( $apiUrl );
		if ( empty( $apiContents ) ) {
	 		return null;
	 	}

		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$dom->loadXML( $apiContents );

		$embedId = $dom->getElementsByTagName( 'embedLookup' )->item( 0 )->textContent;

		$wgMemc->set( $cacheKey, $embedId, 60 * 60 * 24 );

		return $embedId;
	}
}