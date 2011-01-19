<?php 

class WikiaValidatorString extends WikiaValidator {
	
	function __construct(array $options = array(), array $msg = array()) {
		$this->msg = array( 
			'too_short' => "wikia-validator-string-short",
			'too_long'  => "wikia-validator-string-long",  
		);
		$this->options = array(
			'min' => 0, 
			'max' => 255 
		);
		parent::__construct($options, $msg);
	}
	
	public function isValid($value = null) {
		$this->errors = array();
		if(strlen($value) < $this->options['min']) {
			$this->errors['too_short'] = $this->msg['too_short'];
			return false;
		}
		
		if(strlen($value) > $this->options['max']) {
			$this->errors['too_long'] = $this->msg['too_long'];
			return false;
		}
		return true;
	}
}
