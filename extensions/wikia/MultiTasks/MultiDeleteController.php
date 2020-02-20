<?php

declare( strict_types=1 );

use Wikia\Logger\Loggable;

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
		$pagesToDelete = $this->getVal( 'pagesToDelete' );
		$user = $this->getVal( 'user' );
		$reason = $this->getVal( 'reason' );
		if ( empty( $pagesToDelete ) || empty( $user ) ||  empty( $reason ) ) {
			$this->response->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			return;
		}

		foreach ( $pagesToDelete as $pageName ) {
			$page = WikiPage::factory( \Title::newFromText( $pageName ) );

			if ( $page !== null ) {
				$e = '';
				$page->doDeleteArticle( $reason, false, null, null, $e, $user );
			}
		}
	}
}
