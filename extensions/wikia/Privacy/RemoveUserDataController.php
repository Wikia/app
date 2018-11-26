<?php

use Wikia\Logger\Loggable;
use Wikia\Tasks\Queues\Queue;

class RemoveUserDataController extends WikiaController {
	use Loggable;

	const ACCEPTED = 202;
	const METHOD_NOT_ALLOWED = 405;

	public function allowsExternalRequests() {
		return false;
	}

	public function removeUserData() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( self::METHOD_NOT_ALLOWED );
			return;
		}

		$userId = $this->getVal( 'userId' );
		if ( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$this->info( "Right to be forgotten request for user $userId", ['userId' => $userId] );

		$dataRemover = new UserDataRemover();
		$auditLogId = $dataRemover->removeAllPersonalUserData( $userId );
		

		$this->response->setCode( self::ACCEPTED );
		$this->response->setValues( ['auditLogId' => $auditLogId] );
	}

	/**
	 * Helper function to assess the scope of removal.
	 */
	public function getRemoveDetails() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$userId = $this->getVal( 'userId' );
		if ( empty( $userId ) ) {
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

		$userId = (int) $this->getVal( 'userId' );
		if ( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$specialsDbr = self::getSpecialsDB();

		$logEntry = $specialsDbr->selectRow(
			RemovalAuditLog::LOG_TABLE,
			[
				'id',
				'created',
				'number_of_wikis',
			],
			[
				'user_id' => $userId
			],
			__METHOD__
		);

		// there's no entry for a given user ID
		if ( empty( $logEntry ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_NOT_FOUND );
			return;
		}

		// count all completed per-wiki tasks
		$wikisCompleted = (int) $specialsDbr->selectField(
			RemovalAuditLog::DETAILS_TABLE,
			'count(*)',
			[
				'log_id' => $logEntry->id
			]
		);

		// we assume that the process is completed when all per-wiki tasks are done
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
		$this->response->setValues( [
			'userId' => $userId,
			'logId' => $logEntry->id,
			'created' => $logEntry->created,
			'is_completed' => $wikisCompleted === (int) $logEntry->number_of_wikis,
		] );
	}

	/**
	 * Invalidates the given user's email and removes it from memcache.
	 * The email will not be reloaded from the DB unless a new value is set, or user cache is deleted.
	 */
	public function removeEmailFromCache() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( self::METHOD_NOT_ALLOWED );
			return;
		}

		$userId = $this->getVal( 'userId' );
		if ( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$user = User::newFromId( $userId );
		$user->invalidateEmail();
		// setting a blank email will prevent db reloads
		$user->setEmail('');
		$user->invalidateCache();
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
