<?php

declare( strict_types=1 );

final class UserPageDeleteController extends WikiaController {
	public function allowsExternalRequests() {
		return false;
	}

	/**
	 * Introduced for UCP. This method will be triggered by UCP to delete user pages.
	 * This should be executed in context of a wiki.
	 */
	public function deletePage() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );
			return;
		}

		$reason = $this->getVal( 'reason' );
		$requester = $this->getVal( 'requester' );
		$pageNames = $this->getVal( 'pages' );
		if ( empty( $reason ) || empty( $requester ) || empty( $pageNames ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		$userPageDeleter = new UserPageDeleter();
		$userPageDeleter->deletePages( $pageNames, User::newFromId( $requester ), $reason );
	}
}
