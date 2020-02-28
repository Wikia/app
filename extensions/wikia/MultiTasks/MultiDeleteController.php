<?php

declare( strict_types=1 );

use Wikia\Logger\Loggable;

final class MultiDeleteController extends WikiaController {
	use Loggable;

	private const ALL = 'all';
	private const CURRENT = 'id';
	private const LANGUAGE = 'lang';
	private const SELECTED = 'list';

	public function allowsExternalRequests() {
		return false;
	}

	public function multiDeletePages() {
		global $IP;

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );
			return;
		}

		$pagesToDelete = $this->getVal( 'pages' );
		$userId = $this->getVal( 'user' );
		$reason = $this->getVal( 'reason' );
		$firstWikiId = $this->getVal( 'firstWikiId' );
		$lastWikiId = $this->getVal( 'lastWikiId' );
		$runOnType = $this->getVal( 'runOnType' );
		$runOnValue = $this->getVal( 'runOnValue' );

		if (
			empty( $pagesToDelete ) ||
			empty( $userId ) ||
			empty( $reason ) ||
			empty( $firstWikiId ) ||
			empty( $lastWikiId ) ||
			empty( $runOnType ) ||
			empty( $runOnValue )
		) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$wikis = self::getWikisForPageDelete( $firstWikiId, $lastWikiId, $runOnType, $runOnValue );

		$pages = json_encode( $pagesToDelete );
		foreach( $wikis as $wiki ) {
			$command = implode( ' ', array_merge( [
				"SERVER_ID={$wiki->city_id}",
				"php",
				"{$IP}/extensions/wikia/MultiTasks/maintenance/DeleteWikiPage.php",
				"--pagesToDelete={$pages}",
				"--reason={$reason}",
				"--user={$userId}"
			]) );
			$status = 0;
			wfShellExec( $command, $status );

			if ($status) {
				$this->error(__CLASS__ . " Error while running DeleteWikiPage.php", [
					'wikiId' => $wiki->city_id,
					'pages' => $pages,
					'user' => $userId
				]);
			} else {
				$this->info(__CLASS__ . " Finished running DeleteWikiPage.php ", [
					'wikiId' => $wiki->city_id,
					'pages' => $pages,
					'user' => $userId
				]);
			}
		}

		$this->response->setCode( WikiaResponse ::RESPONSE_CODE_OK );
	}

	private function getWikisForPageDelete( $firstId, $lastId, $runOnType, $runOnValue ) {
		global $wgExternalSharedDB;
		$dbr = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		switch( $runOnType ) {
			case MultiDeleteController::ALL:
			case MultiDeleteController::SELECTED:
			case MultiDeleteController::CURRENT:
				return $dbr->select(
					'city_list',
					'city_id',
					[
						'city_public' => '1',
						'city_id >=' . $firstId,
						'city_id <=' . $lastId
					]
				);
			case MultiDeleteController::LANGUAGE:
				return $dbr->select(
					'city_list',
					'city_id',
					[
						'city_lang' => $runOnValue,
						'city_id >=' . $firstId,
						'city_id <=' . $lastId
					]
				);
		}
	}
}
