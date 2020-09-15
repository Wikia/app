<?php

use Wikia\Logger\WikiaLogger;

/**
 * A wrapper for Sailthru's PHP API client
 */
class SailthruGateway {

	/** @var SailthruGateway */
	private static $instance;

	/** @var Sailthru_Client */
	private $client;

	private function __construct() {
		// TODO: Get API key and secret from vault when secrets.php is removed
		global $wgSailthruApiKey, $wgSailthruApiSecret;

		$this->client = new Sailthru_Client($wgSailthruApiKey, $wgSailthruApiSecret);
		$this->logger = WikiaLogger::instance();
	}

	public static function getInstance() {
		if ( static::$instance == null ) {
			static::$instance = new SailthruGateway();
		}

		return static::$instance;
	}

	/**
	 * Add or update a user's data
	 *
	 * @param User $user
	 */
	public function saveUser( User $user ) {
		$data = [
			// extid is user_id
			'key' => 'extid',
			'keys' => [
				'email' => $user->getEmail(),
			],
			'keysconflict' => 'merge',
			'vars' => [
				'birth_date' => $user->mBirthDate,
				'name' => $user->getRealName(),
				'user_name' => $user->getName(),
			],
		];
		try {
			$this->client->saveUser( $user->getId(), $data );
		} catch ( Exception $e ) {
			$this->logger->error(
				'Sailthru API request to save user failed',
				[
					'user_id' => $user->getId(),
					'exception' => $e,
				]
			);
		}
	}

	/**
	 * Remove a user from Sailthru
	 *
	 * @param User $user
	 */
	public function deleteUser( User $user ) {
		$data = [
			'id' => $user->getId(),
			'key' => 'extid',
		];
		try {
			$this->client->apiDelete( 'user', $data );
		} catch ( Exception $e ) {
			$this->logger->error(
				'Sailthru API request to delete user failed',
				[
					'user_id' => $user->getId(),
					'exception' => $e,
				]
			);
		}
	}
}
