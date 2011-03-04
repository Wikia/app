<?php

class UAD {
	const TOKEN_DB_NAME = 'uad_token';
	const EVENT_DB_NAME = 'uad_event';

	/**
	 * @var WikiaApp
	 */
	protected $app = null;

	public function __construct(WikiaApp $app) {
		$this->app = $app;
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_MASTER ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgExternalDatawareDB' ) );
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
	public function storeEvents( $token, Array $events ) {
		$db = $this->getDb();
		foreach( $events as $event ) {
			$db->insert( self::EVENT_DB_NAME, array( 'uev_token' => $token, 'uev_type' => $event['type'], 'uev_date' => $event['date'] ), __METHOD__ );
		}
		$db->commit();
	}

}