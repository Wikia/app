<?php

declare( strict_types=1 );

use Wikia\Logger\Loggable;
use User;

final class MultiDeleteController extends WikiaController {
	use Loggable;

	public function allowsExternalRequests() {
		return false;
	}

	public function multiDeletePages() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		if ( !$this->request->wasPosted() ) {
			$this->response->setCode( 405 );
			return;
		}
		$pagesToDelete = $this->getVal( 'pages' );
		$userId = $this->getVal( 'user' );
		$reason = $this->getVal( 'reason' );
		if ( empty( $pagesToDelete ) || empty( $userId ) ||  empty( $reason ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}
		$user = User::newFromId( $userId );

		foreach ( $pagesToDelete as $pageName ) {
			$page = WikiPage::factory( \Title::newFromText( $pageName ) );
			$pageId = $page->getId();

			if ( $page !== null ) {
				$e = '';
				$page->doDeleteArticle( $reason, false, $pageId, true, $e, $user );
			}
		}
		$this->response->setCode( WikiaResponse ::RESPONSE_CODE_OK );
	}
}
