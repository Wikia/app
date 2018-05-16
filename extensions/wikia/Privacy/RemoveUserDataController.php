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

		$username = User::whoIs( $userId );
		$fakeUser = $this->getFakeUser($username);
		$fakeUsername = !empty( $fakeUser ) ? $fakeUser->getName() : null;

		$dataRemover = new UserDataRemover();

		if ( !empty( $fakeUser ) ) {
			$dataRemover->removeGlobalData( $userId, $fakeUser );
		} else {
			$dataRemover->removeGlobalData( $userId );
		}

		$this->info( "Global data removed for user $userId", [ 'userId' => $userId ] );

		$userWikis = $this->getUserWikis( $userId );

		$wikiCount = count( $userWikis );

		$removeWikiDataTask = new RemoveUserDataOnWikiTask();
    
		$removeWikiDataTask->call( 'removeAllData', $userId, $username, $fakeUsername );
		$removeWikiDataTask->setQueue( Queue::RTBF_QUEUE_NAME )->wikiId( $userWikis )->queue();

		$this->info( "Wiki data removal queued for user $userId", ['userId' => $userId] );

		$this->response->setCode( self::ACCEPTED );
		$this->response->setValues( [
			'userId' => $userId,
			'username' => $username,
			'numberOfWikis' => $wikiCount
		] );
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

	private function getUserWikis( int $userId ) {
		global $wgSpecialsDB;
		$specialsDbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		return $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id', ['user_id' => $userId], __METHOD__, ['DISTINCT'] );
	}

	/**
	 * Returns fake user created in rename user process
	 */
	private function getFakeUser( $username ) {
		$dbr = wfGetDB( DB_SLAVE, [], 'wikicities' );

		$fakeUserId = $dbr->selectField( 'user_properties', 'up_user', [
			'up_property' => 'renameData',
			'up_value' => "renamed_to=$username",
		], __METHOD__ );

		return !empty( $fakeUserId ) ? User::newFromId( $fakeUserId ) : null;
	}

	protected function getLoggerContext() {
		// make right to be forgotten logs more searchable
		return ['right_to_be_forgotten' => 1];
	}

}
