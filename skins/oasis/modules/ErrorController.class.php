<?php

class ErrorController extends WikiaController {

	public function index() {
		$errors = $this->request->getArray( 'errors' );
		if ( isset( $errors['controller'] ) ) {
			unset( $errors['controller'] );
		}
		if ( isset( $errors['method'] ) ) {
			unset( $errors['method'] );
		}
		$this->headline = wfMessage( 'oasis-modal-error-headline' )->escaped();
		$this->errors = $errors;
	}
}
