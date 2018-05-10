<?php

use Wikia\Logger\WikiaLogger;

class RemoveUserDataController extends WikiaController {

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
		$userWikis = $specialsDbr->selectFieldValues( 'events_local_users', 'wiki_id', ['user_id' => $userId], __METHOD__, ['DISTINCT'] );
		$username = User::whoIs( $userId );
		if ( $isDryRun ) {
			$n = count( $userWikis );
			WikiaLogger::instance()->info( "Will remove user:$userId:$username local data from $n wikis" );
		} else {
			$removeWikiDataTask = new RemoveUserDataOnWikiTask();
			$removeWikiDataTask->call( 'removeAllData', $userId,  $username);
			$removeWikiDataTask->wikiId( $userWikis )->queue();
		}
		$this->response->setCode( self::ACCEPTED );
	}

}