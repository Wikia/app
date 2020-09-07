<?php

use Wikia\Logger\Loggable;

class RemoveUserDataController extends WikiaController {
	use Loggable;

	const ACCEPTED = 202;
	const METHOD_NOT_ALLOWED = 405;

	public function allowsExternalRequests() {
		return false;
	}

	public function removeUserData() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if( !$this->request->wasPosted() ) {
			$this->response->setCode( self::METHOD_NOT_ALLOWED );
			return;
		}

		$userId = $this->getVal( 'userId' );
		if( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$this->info( "Right to be forgotten request for user $userId", ['userId' => $userId] );

		$dataRemover = new UserDataRemover();
		$auditLogId = $dataRemover->startRemovalProcess( $userId );


		$this->response->setCode( self::ACCEPTED );
		$this->response->setValues( ['auditLogId' => $auditLogId] );
	}

	/**
	 * Helper function to assess the scope of removal.
	 */
	public function getRemoveDetails() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$userId = $this->getVal( 'userId' );
		if( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
		$this->response->setValues( [
			'userId' => $userId,
			'username' => User::whoIs( $userId ),
			'numberOfWikis' => count( $this->getUserWikis( $userId ) )
		] );
	}

	/**
	 * Returns the status (completed / not yet completed) of GDPR process for a given user ID
	 *
	 * @see SUS-5785
	 */
	public function getRemoveStatus() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$userId = (int)$this->getVal( 'userId' );
		if( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$specialsDbr = self::getSpecialsDB();

		$rows = $specialsDbr->select(
			RemovalAuditLog::LOG_TABLE,
			[
				'id',
				'created',
				'number_of_wikis',
			],
			[
				'user_id' => $userId
			],
			__METHOD__,
			[
				// we only want the last log related to the user
				'ORDER BY' => 'created DESC'
			]
		);

		$logEntries = iterator_to_array( $rows );

		// there's no entry for a given user ID
		if( empty( $logEntries ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			return;
		}

		foreach( $logEntries as $logEntry ) {
			// if there is a successful log entry, return it
			if( RemovalAuditLog::allDataWasRemoved( $logEntry->id ) ) {
				$this->okResponse( $userId, $logEntry->id, $logEntry->created, true );
				return;
			}
		}

		$firstEntry = reset($logEntries);

		// if all log entries are unsuccessful, return the latest fail
		$this->okResponse( $userId, $firstEntry->id, $firstEntry->created, false );
	}

	private function okResponse( $userId, $logId, $created, $dataWasRemoved ) {
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
		$this->response->setValues( [
			'userId' => $userId,
			'logId' => $logId,
			'created' => $created,
			'is_completed' => $dataWasRemoved
		] );
	}

	/**
	 * Invalidates the given user's email and removes it from memcache.
	 * The email will not be reloaded from the DB unless a new value is set, or user cache is deleted.
	 */
	public function removeEmailFromCache() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if( !$this->request->wasPosted() ) {
			$this->response->setCode( self::METHOD_NOT_ALLOWED );
			return;
		}

		$userId = $this->getVal( 'userId' );
		if( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$user = User::newFromId( $userId );
		$user->invalidateEmail();
		// setting a blank email will prevent db reloads
		$user->setEmail( '' );
		$user->invalidateCache();
	}

	/**
	 * Helper method to remove local user data from the current wiki
	 */
	public function removeLocalUserData() {
		// Set initial response code to 500. It will be overridden when request is successful
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if( !$this->request->wasPosted() ) {
			$this->response->setCode( self::METHOD_NOT_ALLOWED );
			return;
		}

		$auditLogId = $this->getVal( 'auditLogId' );

		$userIds = $this->getVal( 'userIds' );
		if ( empty( $userIds ) ) {
			$userIds = array_filter( [
				$this->getVal( 'userId' ),
				$this->getVal( 'renameUserId' ),
			]);
		}

		if ( empty( $userIds ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$marker = [
			'user_id' => $userIds[0],
			'rename_user_id' => $userIds[1] ?? null,
			'rtbf_log_id' => $auditLogId
		];

		$this->info( "Removing local user data", $marker );

		$localDataRemover = new LocalUserDataRemover();
		$dataWasRemoved = $localDataRemover->removeLocalUserDataOnThisWiki( $auditLogId, $userIds );

		if ( !$dataWasRemoved ) {
			$this->error( "User's local data was not removed correctly", $marker );
		}

		$this->info( "Deleting user cache", $marker );

		foreach ($userIds as $userId) {
			$user = User::newFromId( $userId );
			$user->deleteCache();
		}

		$this->info( "User's local data was removed", $marker );
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}

	private function getUserWikis( int $userId ) {
		$specialsDbr = self::getSpecialsDB();
		return $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id', ['user_id' => $userId], __METHOD__, ['DISTINCT'] );
	}


	private static function getSpecialsDB() {
		global $wgSpecialsDB;
		return wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return ['right_to_be_forgotten' => 1];
	}

}
