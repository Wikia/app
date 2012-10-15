<?php

class SouthParkStudiosVideoProvider extends MTVNetworksVideoProvider {
	protected $videoRegexId = '#/clips/(\d+)/#';

	public static function getDomains() {
		return array( 'southparkstudios.com' );
	}

	protected function extractVideoId( $url ) {
		if ( !preg_match( '#/clips/(\d+)/#', $url, $matches ) ) {
			return null;
		}

		return "mgid:cms:item:southparkstudios.com:{$matches[1]}";
	}
}