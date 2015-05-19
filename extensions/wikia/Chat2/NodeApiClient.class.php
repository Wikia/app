<?php
/**
 * Even though the Predis 5.2 backport works swimmingly, given the layout of our network (chat server and its local redis instance running in the public network)
 * and the fact that redis is essentially unsecured, it is not safe for our MediaWiki server to make requests to redis.
 *
 * To allow the MediaWiki app to interface with the chat data in redis, there is a simple API running from the same server.js script as the main chat server (on a
 * different port though).  This API will encapsulate simple tasks that require access to the redis server.
 *
 * @author Sean Colombo
 */
class NodeApiClient {
	/**
	 * Given a roomId, fetches the wgCityId from redis. This will
	 * allow the auth class to verify that the room is in the same
	 * that the connection is attempting to be made from (prevents
	 * circumventing bans by connecting to Wiki A's chat via Wiki B).
	 */
	static public function getCityIdForRoom( $roomId ) {
		wfProfileIn( __METHOD__ );

		$cityId = "";
		$cityJson = NodeApiClient::makeRequest( array(
			"func" => "getCityIdForRoom",
			"roomId" => $roomId
		) );
		$cityData = json_decode( $cityJson );
		if ( isset( $cityData->{ 'cityId' } ) ) {
			$cityId = $cityData->{ 'cityId' };
		} else {
			// FIXME: How should we handle it if there is no cityId?
			ChatHelper::info( __METHOD__ . ': Method called - no cityId', [
				'roomId' => $roomId,
			] );
		}

		wfProfileOut( __METHOD__ );

		ChatHelper::info( __METHOD__ . ': Method called', [
			'roomId' => $roomId,
			'cityId' => $cityId,
		] );

		return $cityId;
	} // end getCityIdForRoom()

	/**
	 * Returns the id of the default chat for the current wiki.
	 *
	 * If the chat doesn't exist, creates it.
	 *
	 * @param roomUsers - for private chats: an array of users who are in the room.
	 *
	 * TODO: Document what format these users are in (user ids? db_keys?)
	 *
	 * @return string
	 */
	static public function getDefaultRoomId( $roomType = "open", $roomUsers = [] ) {
		global $wgCityId, $wgServer, $wgArticlePath;
		wfProfileIn( __METHOD__ );

		if ( empty( $roomData ) ) { // TODO: FIXME: What is this testing? Isn't it ALWAYS empty? - SWC 20110905
			// Add some extra data that the server will want in order to store it in the room's hash.
			$extraData = array(
				'wgServer' => $wgServer,
				'wgArticlePath' => $wgArticlePath
			);
			$extraDataString = json_encode( $extraData );

			$roomId = "";
			$roomJson = NodeApiClient::makeRequest( array(
				"func" => "getDefaultRoomId",
				"wgCityId" => $wgCityId,
				"roomType" => $roomType,
				"roomUsers" => json_encode( $roomUsers ),
				"extraDataString" => $extraDataString
			) );

			$roomData = json_decode( $roomJson );
		}

		if ( isset( $roomData->{ 'roomId' } ) ) {
			$roomId = $roomData->{ 'roomId' };
			ChatHelper::info( __METHOD__ . ': Method called', [
				'roomId' => $roomId,
			] );
		} else {
			// FIXME: How should we handle it if there is no roomId?
			ChatHelper::info( __METHOD__ . ': Method called - no roomId' );
		}

		wfProfileOut( __METHOD__ );
		return $roomId;
	} // end getDefaultRoomId()


	static public function getChatters() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "NodeApiClient::getChatters" );

		// data are store in memcache and set by node.js
		$chatters = $wgMemc->get( $memKey, false );
		if ( !$chatters ) {
			$chatters = array();
		}

		wfProfileOut( __METHOD__ );
		return $chatters;
	}

	static public function setChatters( $chatters ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "NodeApiClient::getChatters" );
		$wgMemc->set( $memKey, $chatters, 60 * 60 * 24 );

		wfProfileOut( __METHOD__ );
	}


	/**
	 * Does the request to the Node server and returns the responseText (empty string on failure).
	 */
	static private function makeRequest( $params ) {
		global $wgReadOnly;
		wfProfileIn( __METHOD__ );
		$response = "";

		ChatHelper::debug( __METHOD__ . ': Method called ', $params );

		// NOTE: When we fail over, the chat server host doesn't change which backend it points to (since there isn't
		// even a chat server in the backup datacenter(s)), so if we're in read-only, even though this isn't a write
		// operation, abort trying to contact the node server since it could be unavailable (in the event of complete
		// network unavailability in the primary datacenter). - BugzId 11047
		if ( empty( $wgReadOnly ) ) {
			$requestUrl = "http://" . NodeApiClient::getHostAndPort() . "/api?" . http_build_query( $params );
			$response = Http::get( $requestUrl, 'default', array( 'noProxy' => true ) );
			if ( $response === false ) {
				$response = "";
			}
		}

		wfProfileOut( __METHOD__ );
		return $response;
	}

	/**
	 * Return the appropriate host and port for the client to connect to.
	 * This is based on whether this is dev or prod, but can be overridden
	 */
	static protected function getHostAndPort() {
		global $wgDevelEnvironment;

		$server = ChatHelper::getServer( 'Api' );

		$server = ChatHelper::getServer( 'Api' );
		$hostAndPort = $server['host'] . ':' . $server['port'];

		return $hostAndPort;



	} // end getHostAndPort()

}
