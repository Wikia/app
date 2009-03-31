<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
	
class AbuseFilterException extends MWException {}

class AbuseFilterParserNative {
	var $mVars;
	var $mProcess,$mPipes;
	
	public function __construct() {
		$this->mVars = array();
	}
	
	public function __destruct() {
		if (is_array($this->mPipes)) {
			foreach( $this->mPipes as $pipe ) {
				fclose($pipe);
			}
		}
		
		if (is_resource($this->mProcess)) {
			proc_terminate( $this->mProcess );
		}
	}
	
	public function setVar( $name, $var ) {
		$this->mVars[$name] = $var;
	}
	
	public function setVars( $vars ) {
		foreach( $vars as $name => $var ) {
			$this->setVar( $name, $var );
		}
	}
	
	public function getNativeParser() {	
		global $wgAbuseFilterNativeParser;
		
		if (!is_resource($this->mProcess)) {
			$this->mPipes = array();
			$descriptorspec = array( 
					0 => array( 'pipe', 'r' ),
					1 => array( 'pipe', 'w' )
				);
				
			$this->mProcess = proc_open( $wgAbuseFilterNativeParser, $descriptorspec, $this->mPipes );
			
			if (!is_resource($this->mProcess)) {
				throw new MWException( "Error using native parser" );
			}
			
			return $this->mPipes;
		}
		
		return $this->mPipes;
	}
	
	public function checkSyntax( $filter ) {
		global $wgAbuseFilterNativeSyntaxCheck;
		
		// Check the syntax of $filter
		$pipes = array();
		$descriptorspec = array(
				0 => array( 'pipe', 'r' ),
				1 => array( 'pipe', 'w' )
			);
		
		$proc = proc_open( $wgAbuseFilterNativeSyntaxCheck, $descriptorspec, $pipes );
		
		if (!is_resource( $proc )) {
			throw new MWException( "Unable to check syntax of filter." );
		}
		
		fwrite( $pipes[0], $filter );
		fflush( $pipes[0] );
		fclose( $pipes[0] );
		
		$response = trim(fgets( $pipes[1] ) );
		
		if ($response == "SUCCESS") {
			return true;
		} else {
			list ($discard,$error) = explode( ":", $response, 2 );
			return $error;
		}
	}
	
	public function parse( $filter ) {
		$request = $this->generateRequest( $filter );
		
		$pipes = $this->getNativeParser();
		
		if (is_array($pipes)) {
			fwrite($pipes[0], $request);
			fflush($pipes[0]);

			// Get response
			$response = trim(fgets( $pipes[1] ));
			
			if ($response == "MATCH") {
				return true;
			} elseif ($response == "NOMATCH") {
				return false;
			} elseif (in_string( 'EXCEPTION', $response ) ) {
				throw new AbuseFilterException( "Native parser $response" );
			} else {
				throw new AbuseFilterException( "Unknown output from native parser: $response" );
			}
		}
	}
	
	public function evaluateExpression( $filter ) {
		$request = $this->generateRequest( $filter );
		
		global $wgAbuseFilterNativeExpressionEvaluator;
		
		// Check the syntax of $filter
		$pipes = array();
		$descriptorspec = array(
				0 => array( 'pipe', 'r' ),
				1 => array( 'pipe', 'w' )
			);
		
		$proc = proc_open( $wgAbuseFilterNativeExpressionEvaluator, $descriptorspec, $pipes );
		
		if (!is_resource( $proc )) {
			throw new MWException( "Unable to evaluate expression." );
		}
		
		fwrite( $pipes[0], $request );
		fflush( $pipes[0] );
		fclose( $pipes[0] );
		
		$response = trim(stream_get_line( $pipes[1], 4096, "\0" ) );
		
		return $response;
	}
	
	protected function generateRequest( $filter ) {
		// Write vars
		$request = '';
		$request .= $filter;
		$request .= "\0";
		
		// Key-value pairs
		foreach( $this->mVars as $key => $value ) {
			$request .= "$key\0$value\0";
		}
		
		$request .= "\0";
		
		return $request;
	}
}
