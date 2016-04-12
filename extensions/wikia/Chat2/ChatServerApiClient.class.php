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
class ChatServerApiClient {
	const ROOM_TYPE_PUBLIC = 'open';
	const ROOM_TYPE_PRIVATE = 'private';

	/**
	 * Given a roomId, fetches the wgCityId from redis. This will
	 * allow the auth class to verify that the room is in the same
	 * that the connection is attempting to be made from (prevents
	 * circumventing bans by connecting to Wiki A's chat via Wiki B).
	 *
	 * @param int $roomId
	 * @return string
	 */
	static public function getCityIdFromRoomId( $roomId ) {
		wfProfileIn( __METHOD__ );

		$cityId = "";
		$cityData = ChatServerApiClient::makeRequest( array(
			"func" => "getCityIdForRoom",
			"roomId" => $roomId
		) );

		if ( isset( $cityData->cityId ) ) {
			$cityId = $cityData->cityId;
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
	}

	/**
	 * Return public room id for the current wiki. It is created if does not exist.
	 *
	 * @return int|null
	 */
	static public function getPublicRoomId() {
		return self::getRoomId(self::ROOM_TYPE_PUBLIC);
	}

	/**
	 * Return private room id for the specified users for the current wiki. It is created if does not exist.
	 *
	 * @param string[] $userNames List of user names
	 * @return int|null
	 */
	static public function getPrivateRoomId( $userNames ) {
		return self::getRoomId(self::ROOM_TYPE_PRIVATE, $userNames);
	}

	/**
	 * Returns the id of the chat room of the given type for the current wiki.
	 *
	 * If the chat doesn't exist, creates it.
	 *
	 * @param string $roomType One of ChatServerApiClient::ROOM_TYPE_*
	 * @param array $roomUsers List of usernames for private rooms
	 * @return int|null
	 */
	static private function getRoomId( $roomType, $roomUsers = [ ] ) {
		global $wgCityId, $wgServer, $wgArticlePath;
		wfProfileIn( __METHOD__ );

		$roomId = null;

		// Add some extra data that the server will want in order to store it in the room's hash.
		$extraData = array(
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		);
		$extraDataString = json_encode( $extraData );

		$roomData = ChatServerApiClient::makeRequest( array(
			"func" => "getDefaultRoomId",
			"wgCityId" => $wgCityId,
			"roomType" => $roomType,
			"roomUsers" => json_encode( $roomUsers ),
			"extraDataString" => $extraDataString
		) );

		if ( isset( $roomData->roomId ) ) {
			$roomId = $roomData->roomId;
			ChatHelper::info( __METHOD__ . ': Method called', [
				'roomId' => $roomId,
			] );
		} else {
			// FIXME: How should we handle it if there is no roomId?
			ChatHelper::info( __METHOD__ . ': Method called - no roomId' );
		}

		wfProfileOut( __METHOD__ );

		return $roomId;
	}

	/**
	 * Performs HTTP request do Chat server and returns decoded JSON or null
	 *
	 * @param array $params
	 * @return mixed|null
	 */
	static private function makeRequest( $params ) {
		global $wgReadOnly;
		wfProfileIn( __METHOD__ );

		$response = null;

		ChatHelper::debug( __METHOD__ . ': Method called ', $params );

		// NOTE: When we fail over, the chat server host doesn't change which backend it points to (since there isn't
		// even a chat server in the backup datacenter(s)), so if we're in read-only, even though this isn't a write
		// operation, abort trying to contact the node server since it could be unavailable (in the event of complete
		// network unavailability in the primary datacenter). - BugzId 11047
		if ( empty( $wgReadOnly ) ) {
			$requestUrl = "http://" . ChatServerApiClient::getHostAndPort() . "/api?" . http_build_query( $params );
			$response = Http::get( $requestUrl, 'default', array( 'noProxy' => true ) );
			if ( $response === false ) {
				$response = null;
			}
		}

		if ( $response !== null ) {
			$response = json_decode( $response );
		}

		wfProfileOut( __METHOD__ );

		return $response;
	}

	/**
	 * Return the appropriate host and port for the client to connect to.
	 * This is based on whether this is dev or prod, but can be overridden
	 */
	static protected function getHostAndPort() {
		$server = ChatConfig::getApiServer();
		$hostAndPort = $server['host'] . ':' . $server['port'];

		return $hostAndPort;
	}

}
