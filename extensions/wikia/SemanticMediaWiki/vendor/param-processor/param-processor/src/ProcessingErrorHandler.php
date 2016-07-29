<?php

namespace ParamProcessor;

/**
 * Static class for error handling.
 * 
 * @since 0.4
 * @deprecated since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class ProcessingErrorHandler {
	
	/**
	 * @since 0.4
	 * 
	 * @var array of ProcessingError
	 */
	protected static $errors = array();
	
	/**
	 * Adds a single ProcessingError.
	 * 
	 * @since 0.4
	 * 
	 * @param string $errorMessage
	 * @param integer $severity
	 */
	public static function addError( ProcessingError $error ) {
		self::$errors[$error->getElement()][] = $error;
	}
	
	/**
	 * Adds a list of ProcessingError.
	 * 
	 * @since 0.4
	 * 
	 * @param array $errors
	 */	
	public static function addErrors( array $errors ) {
		foreach ( $errors as $error ) {
			self::addError( $error );
		}
	}
	
	/**
	 * Returns a list of all registered errors.
	 * 
	 * @since 0.4
	 * 
	 * @return array of ProcessingError
	 */
	public static function getErrors() {
		return self::$errors;
	}
	
}