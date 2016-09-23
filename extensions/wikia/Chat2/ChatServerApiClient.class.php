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
	public static function getCityIdFromRoomId( $roomId ) {
		wfProfileIn( __METHOD__ );

		$cityId = '';
		$cityData = self::makeRequest( [
			"func" => "getCityIdForRoom",
			"roomId" => $roomId
		] );

		if ( isset( $cityData->cityId ) ) {
			$cityId = $cityData->cityId;
		} else {
			Chat::info( __METHOD__ . ': Method called - no cityId', [
				'roomId' => $roomId,
			] );
		}

		Chat::info( __METHOD__ . ': Method called', [
			'roomId' => $roomId,
			'cityId' => $cityId,
		] );

		wfProfileOut( __METHOD__ );

		return $cityId;
	}

	/**
	 * Return public room id for the current wiki. It is created if does not exist.
	 *
	 * @return int|null
	 */
	public static function getPublicRoomId() {
		return self::getRoomId( self::ROOM_TYPE_PUBLIC );
	}

	/**
	 * Return private room id for the specified users for the current wiki. It is created if does not exist.
	 *
	 * @param string[] $userNames List of user names
	 * @return int|null
	 */
	public static function getPrivateRoomId( $userNames ) {
		return self::getRoomId( self::ROOM_TYPE_PRIVATE, $userNames );
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
	private static function getRoomId( $roomType, $roomUsers = [ ] ) {
		global $wgCityId, $wgServer, $wgArticlePath;

		wfProfileIn( __METHOD__ );

		$roomId = null;

		// Add some extra data that the server will want in order to store it in the room's hash.
		$extraData = [
			'wgServer' => $wgServer,
			'wgArticlePath' => $wgArticlePath
		];
		$extraDataString = json_encode( $extraData );

		$roomData = self::makeRequest( [
			"func" => "getDefaultRoomId",
			"wgCityId" => $wgCityId,
			"roomType" => $roomType,
			"roomUsers" => json_encode( $roomUsers ),
			"extraDataString" => $extraDataString
		] );

		if ( isset( $roomData->roomId ) ) {
			$roomId = $roomData->roomId;
			Chat::info( __METHOD__ . ': Method called', [
				'roomId' => $roomId,
			] );
		} else {
			// FIXME: How should we handle it if there is no roomId?
			Chat::info( __METHOD__ . ': Method called - no roomId' );
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
	private static function makeRequest( $params ) {
		global $wgReadOnly;

		wfProfileIn( __METHOD__ );

		$response = null;

		Chat::debug( __METHOD__ . ': Method called ', $params );

		// NOTE: When we fail over, the chat server host doesn't change which backend it points to (since there isn't
		// even a chat server in the backup datacenter(s)), so if we're in read-only, even though this isn't a write
		// operation, abort trying to contact the node server since it could be unavailable (in the event of complete
		// network unavailability in the primary datacenter). - BugzId 11047
		if ( empty( $wgReadOnly ) ) {
			$requestUrl = "http://" . ChatConfig::getApiServer() . "/api?" . http_build_query( $params );
			$response = Http::get( $requestUrl, 'default', [ 'noProxy' => true ] );
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

}
