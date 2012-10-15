<?php
/**
 * Created on 13 Jan 2009 by Serhii Kutnii
 */

/**
 * An abstract data getter and checker class.
 * Its concrete subclasses should incapsulate all the necessary data getting
 * and environment checks.
 */
abstract class SES_DataChecker
{
	private $mError = null;

	public function getError()
	{
		return $this->mError;
	}

 	/*
 	 * Get a value from the request.
 	 * $err_message_id specifies an error that should be thrown
 	 * if the value is empty
 	 */
 	protected function getUserDataValue( $id, $err_message_id = null )
 	{
 		global $wgRequest;
 		$value = $wgRequest->getText( $id );

 		if ( $err_message_id && !$value )
 			$this->error( wfMsg( $err_message_id ) );

 		return $value;
 	}

	// Checks
	private $mEnvCheckCalls = array();

	protected function addCheck( $method_callback, array $args )
	{
		$this->mEnvCheckCalls[] = array( $method_callback, $args );
	}

	protected function runChecks()
	{
		foreach ( $this->mEnvCheckCalls as $call_array )
		{
			call_user_func_array( $call_array[0], $call_array[1] );
		}
	}

	// Abstracting error calls in order to make this functionality changeable in subclasses
	protected function error( $message )
	{
		throw new Exception( $message );
	}

	abstract protected function populateData();

	public function run()
	{
		try
		{
			$this->populateData();
			$this->runChecks();
		}
		catch ( Exception $e )
		{
			$this->mError = $e->getMessage();
		}
	}
}
