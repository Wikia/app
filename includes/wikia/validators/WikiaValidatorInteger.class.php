<?php 

class WikiaValidatorInteger extends WikiaValidator {
	function __construct(array $options = array(), array $msg = array()) {
		$this->msg = array( 
			'too_small' => "wikia-validator-integer-too-small",
			'too_big'  =>  "wikia-validator-integer-too-big",
			'not_int' =>  "wikia-validator-integer-not-int",  
		);
		$this->options = array(
			'min' => 0, 
			'max' => 32767 
		);
		parent::__construct($options, $msg);
	}
	
	public function isValid($value = null) {
		$this->errors = array();
		
		if(!is_int($value)){
			$this->errors['not_int'] = $this->msg['not_int'];
			return false;
		}
		
		if($value < $this->options['min']) {
			$this->errors['too_small'] = $this->msg['too_small'];
			return false;
		}
		
		if($value > $this->options['max']) {
			$this->errors['too_big'] = $this->msg['too_big'];
			return false;
		}
		return true;
	}
}

