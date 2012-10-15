<?php 

class WikiaValidatorMail extends WikiaValidatorRegex {
	
	protected function config( array $options = array() ) {
		$this->setOption('pattern', '/^([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})$/i' );		
	}
	
}