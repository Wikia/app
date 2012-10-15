<?php

class GametrailersVideoProvider extends MTVNetworksVideoProvider {
	public static function getDomains() {
		return array( 'gametrailers.com' );
	}

	protected function extractVideoId( $url ) {
		if ( !preg_match( '#/(?<type>user-movie|video)/[a-zA-Z0-9\-]+/(?<id>\d+)#', $url, $matches ) ) {
			return null;
		}

		$vidType = '';
		switch ( $matches['type'] ) {
			case 'video':
				$vidType = 'video';
				break;
			case 'user-movie':
				$vidType = 'usermovie';
				break;
			default:
				return null;
		}

		return "mgid:moses:$vidType:gametrailers.com:{$matches['id']}";
	}
}