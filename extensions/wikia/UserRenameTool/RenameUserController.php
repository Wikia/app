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
	}
}
