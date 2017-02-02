<?php

class EmailConfirmationController extends WikiaController {
	/**
	 * Attempt to confirm the user's email address and show success or failure
	 */
	public function postEmailConfirmation() {
		$token = $this->wg->request->getVal( 'token', null );
		$userFromToken = User::newFromConfirmationCode( $token );
		$currentUserId = $this->wg->user->getId();

		if ( !$this->wg->request->wasPosted() ) {
			// Only POST to this resource is allowed
			$this->response->setCode( 405 );
		} elseif ( is_null( $token ) ) {
			// No token given: Bad Request
			$this->response->setCode( 400 );
		} elseif ( !is_object( $userFromToken ) ) {
			// No user has such a token associated: Not Found
			$this->response->setCode( 404 );
		} elseif ( $userFromToken->getId() != $currentUserId ) {
			// Not logged in as a user confirming their token: Unauthorized
			$this->response->setCode( 401 );
		} else {
			$this->confirmEmail( $userFromToken );
			$this->response->setCode( 200 );
			$this->response->setVal( 'username', $userFromToken->getName() );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * Performs an action of confirming email and runs an appropriate hook
	 *
	 * @param $user
	 */
	private function confirmEmail( User $user ) {
		$user->confirmEmail();
		$user->saveSettings();
		wfRunHooks( 'ConfirmEmailComplete', [ &$user ] );
	}
}
