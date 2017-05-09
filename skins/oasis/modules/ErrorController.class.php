<?php
class ErrorController extends WikiaService {

	public function executeIndex($errors) {
		if (isset($errors['controller'])) unset ($errors['controller']);
		if (isset($errors['method'])) unset ($errors['method']);
		$this->headline = wfMsg('oasis-modal-error-headline');
		$this->errors = $errors;
	}
}
