<?php
/**
 * @author: Jacek Jursza
 */
abstract class SDTypeHandler {

	protected $errorObject;
	protected $config;

	public function __construct( $config ) {
		$this->errorObject = new stdClass();
		$this->config = $config;
	}

	public function getErrors() {
		return $this->errorObject;
	}

	protected function addError( $propertyName, $errorMessage ) {
		$this->errorObject->error = true;
		$this->errorObject->message = $errorMessage;
		if ( !isset( $this->errorObject->errors ) ) {
			$this->errorObject->errors = new stdClass();
		}
		$this->errorObject->errors->{$propertyName} = array( 0 => $errorMessage );
	}

	public abstract function handleSaveData( array $data );
}
