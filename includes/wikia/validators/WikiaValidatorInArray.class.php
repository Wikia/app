<?php 

class WikiaValidatorInArray extends  WikiaValidator {
	function __construct(array $options = array(), array $msg = array()) {
		$this->msg = array( 
			'not_allowed_value' => wfMsg("wikia-validator-not-allowed-value"),  
		);
		
		$this->options = array('allowed' => array());
		parent::__construct($options, $msg);
	}
	
	
	public function isValid($value = null) {
		$this->error = array();
		if(!in_array ( $value , $this->options['allowed'] )) {
			$this->error['not_allowed_value'] = $this->msg['not_allowed_value'];
			return false;
		}
		return true;
	}
}
