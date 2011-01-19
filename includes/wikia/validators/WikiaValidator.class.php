<?php 

abstract class WikiaValidator {
	protected $errors = array();
	protected $options = array();
	protected $msg = array();
	
	function __construct(array $options = array(), array $msg = array()) {
		$this->options = $options + $this->options;
		$this->msg = $msg + $this->msg;
	}
	
	abstract public function isValid($value = null);
	
	public function getErrors() {
		return $this->errors;
	}
}
