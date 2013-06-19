<?php

class UAD {
	const TOKEN_DB_NAME = 'uad_token';
	const EVENT_DB_NAME = 'uad_event';
	const EVENT_VISITEDWIKIS_ID = 'visitedWikis';

	/**
	 * @var WikiaApp
	 */
	protected $app = null;

	public function __construct() {
		$this->app = F::app();
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_MASTER ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $type, array(), $wgExternalDatawareDB );
	}

	/**
	 * create new token
	 * @return string token
	 */
	public function createToken() {
		$db = $this->getDb();

		$db->insert( self::TOKEN_DB_NAME, array( 'uto_created' => date('Y-m-d H:i:s') ), __METHOD__ );
		$tokenId = $db->insertId();
		if( empty($tokenId) ) {
			throw new WikiaException( 'Unable to get token ID' );
		}

		$token = md5( $tokenId );
		$db->update( self::TOKEN_DB_NAME, array( 'uto_value' => $token ), array( 'uto_id' => $tokenId ), __METHOD__ );
		$db->commit();

		return $token;
	}

	/**
	 * @todo use scribe
	 */
	public function storeEvents( $token, $date, stdClass $events ) {
		$db = $this->getDb();
		$events = get_object_vars( $events );

		foreach( $events as $eventId => $count ) {
			if( ( $eventId != self::EVENT_VISITEDWIKIS_ID ) && ( $count > 0 ) ) {
				$params = array(
				  'uev_token' => $token,
				  'uev_type' => strtoupper( $eventId ),
				  'uev_date' => $date,
				  'uev_value' => $count );
/*
				if( $this->app->getGlobal( 'wgEnableScribeReport' ) ) {
					// use scribe
					try {
						$message = array( 'method' => 'uad', 'params' => $params );
						WScribeClient::singleton('trigger')->send( json_encode( $message ) );
					}
					catch( TException $e ) {
						Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
					}
				}
				else {
*/
					$db->insert( self::EVENT_DB_NAME, $params, __METHOD__ );
				//}
			}
		}

		if( isset( $events[ self::EVENT_VISITEDWIKIS_ID ] ) ) {
			foreach( $events[ self::EVENT_VISITEDWIKIS_ID ] as $wikiId ) {
				$params = array(
				  'uev_token' => $token,
				  'uev_type' => strtoupper(  self::EVENT_VISITEDWIKIS_ID ),
				  'uev_date' => $date,
				  'uev_value' => $wikiId );
/*
				if( $this->app->getGlobal( 'wgEnableScribeReport' ) ) {
					try {
						$message = array( 'method' => 'uad', 'params' => $params );
						WScribeClient::singleton('trigger')->send( json_encode( $message ) );
					}
					catch( TException $e ) {
						Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
					}
				}
				else {
*/
					$db->insert( self::EVENT_DB_NAME, $params, __METHOD__ );
//				}
			}
		}

		$db->commit();
	}

}