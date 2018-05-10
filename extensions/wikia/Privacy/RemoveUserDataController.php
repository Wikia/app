<?php

use Wikia\Logger\WikiaLogger;

class RemoveUserDataController extends WikiaController {

	const ACCEPTED = 202;

	public function allowsExternalRequests() {
		return false;
	}

	public function removeUserData() {
		$userId = $this->getVal( 'userId' );
		$isDryRun = $this->getVal( 'dryRun' );
		if ( empty( $userId ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		if ( $isDryRun ) {
			WikiaLogger::instance()->info( "Will remove user's global data: $userId" );
		} else {
			UserDataRemover::removeGlobalData( $userId );
		}

		global $wgSpecialsDB;
		$specialsDbr = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		$userWikis = $specialsDbr->selectFieldValues( 'event_local_users', 'wiki_id', ['user_id' => $userId], __METHOD__, ['DISTINCT'] );

		if ( $isDryRun ) {
			$n = count( $userWikis );
			WikiaLogger::instance()->info( "Will remove user's local data ($userId) from $n wikis" );
		} else {
			$removeWikiDataTask = new RemoveUserDataOnWikiTask();
			$removeWikiDataTask->call( 'removeAllData', $userId, User::whoIs( $userId ) );
			$removeWikiDataTask->wikiId( $userWikis )->queue();
		}
		$this->response->setCode( self::ACCEPTED );
	}

}