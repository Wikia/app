<?php
class ErrorModule extends Module {

	var $wgBlankImgUrl;
	var $headline;
	var $errors;
	
	public function executeIndex($errors) {
		global $wgBlankImgUrl;
		
		$this->headline = wfMsg('oasis-modal-error-headline');
		$this->errors = $errors;
	}
	
}