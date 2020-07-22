<?php

declare( strict_types=1 );

use Wikia\Logger\Loggable;
use Wikia\Tasks\Tasks\RenameUserPagesTask;

final class RenameUserController extends WikiaController {
	use Loggable;

	public function allowsExternalRequests() {
		return false;
	}

	/**
	 * Introduced for UCP. This method will be triggered by UCP to rename all necessary pages after an account rename.
	 * This should be executed in context of a wiki.
	 */
	public function renameUserLocally() {
		// Set initial response code to 500. It will be overridden when request is successful
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );

			return;
		}
		$newUsername = $this->getVal( 'newUsername' );
		$oldUsername = $this->getVal( 'oldUsername' );
		if ( empty( $newUsername ) || empty( $oldUsername ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );

			return;
		}

		$task = new RenameUserPagesTask();
		$task->renameLocalPages( $oldUsername, $newUsername );
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}


	/**
	 * Introduced for UCP. This method will be triggered by UCP to schedule renaming all necessary pages after an
	 * account rename.
	 * This can be executed in the context of any wiki, preferably Community Central.
	 */
	public function scheduleLocalRename() {
		// Set initial response code to 500. It will be overridden when request is successful
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );

			return;
		}
		$newUsername = $this->getVal( 'newUsername' );
		$oldUsername = $this->getVal( 'oldUsername' );
		$targetWikiId = (int)$this->getVal( 'targetWikiId' );
		$renameLogId = (int)$this->getVal( 'renameLogId' );
		if ( empty( $newUsername ) || empty( $oldUsername ) || empty( $renameLogId) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );

			return;
		}

		$task = new RenameUserPagesTask();
		$task->call( 'renameLocalPagesAndMarkAsDone', $renameLogId, $oldUsername, $newUsername );
		$task->wikiId( $targetWikiId )->queue();

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}
}
