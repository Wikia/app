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
		// Set initial response code to 500. It will be overridden when request is successful
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_INTERNAL_SERVER_ERROR );
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

		/**
		 * We need to disable Abuse Filter checks to delete user pages
		 * @see https://wikia-inc.atlassian.net/browse/SER-4143
		 */
		$this->disableAbuseFilterHook();

		$userPageDeleter = new UserPageDeleter();
		$userPageDeleter->deletePages( $pageNames, User::newFromId( $requester ), $reason );
		$this->response->setCode( WikiaResponse::RESPONSE_CODE_OK );
	}

	private function disableAbuseFilterHook(): void {
		$handlers = &Hooks::getHandlersArray();
		$newDeleteHandlers = array_filter( $handlers['ArticleDelete'], function ( $handler ): bool {
			return 'AbuseFilterHooks::onArticleDelete' !== $handler;
		} );
		$handlers['ArticleDelete'] = $newDeleteHandlers;
	}
}
