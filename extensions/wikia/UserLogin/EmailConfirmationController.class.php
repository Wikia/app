<?php

class EmailConfirmationController extends WikiaController {
	/**
	 * Attempt to confirm the user's email address and show success or failure
	 */
	public function postEmailConfirmation() {
		$user = User::newFromConfirmationCode( $this->wg->request->getVal( 'token' ) );
		if ( is_object( $user ) ) {
			$user->confirmEmail();
			$user->saveSettings();
			wfRunHooks( 'ConfirmEmailComplete', array( &$user ) );
			$this->response->setCode( 200 );
			$this->response->setVal( 'username', $user->getName() );
		} else {
			//User with such token not found
			$this->response->setCode( 404 );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}
}
