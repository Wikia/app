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
	 * Add a user
	 *
	 * @param User $user
	 * @param string|null $birthdate
	 */
	public function createUser( User $user, $birthdate ) {
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
				'status' => 'active',
			],
		];
		try {
			$this->client->saveUser( $user->getId(), $data );
			$this->logger->info( "sailthru api request user saved", [
				'sailthruResults' => json_encode( $results ),
				'datasent' => json_encode( $data ),
			] );
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

	public function updateUser( User $user, $additionalVars = [] ) {
		$defaultVars = [
			'name' => $user->getRealName(),
			'user_name' => $user->getName(),
		];

		$vars = array_merge( $defaultVars, $additionalVars );

		$data = [
			// extid is user_id
			'key' => 'extid',
			'keys' => [
				'email' => $user->getEmail(),
			],
			'keysconflict' => 'merge',
			'vars' => $vars,
		];
		try {
			$results = $this->client->saveUser( $user->getId(), $data );
			$this->logger->info( "sailthru api request user saved", [
				'sailthruResults' => json_encode( $results ),
				'datasent' => json_encode( $data ),
			] );
		} catch ( \Exception $e ) {
			$this->logger->error(
				'Sailthru API request to save user failed',
				[
					'user_id' => $user->getId(),
					'exception' => $e,
				]
			);
		}
	}

	public function renameUser( User $user, $newName ) {
		$data = [
			// extid is user_id
			'key' => 'extid',
			'keysconflict' => 'merge',
			'vars' => [
				'user_name' => $newName,
			],
		];
		try {
			$results = $this->client->saveUser( $user->getId(), $data );
			$this->logger->info( "sailthru api request user renamed", [
				'sailthruResults' => json_encode( $results ),
				'datasent' => json_encode( $data ),
			] );
		} catch ( \Exception $e ) {
			$this->logger->error(
				'Sailthru API request to rename user failed',
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
			$this->logger->info( "sailthru api request user deleted", [
				'sailthruResults' => json_encode( $results ),
				'datasent' => json_encode( $data ),
			] );
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
