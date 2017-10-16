<?php

namespace ValueValidators;

/**
 * @since 0.1
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Result {

	/**
	 * @since 0.1
	 *
	 * @var bool
	 */
	protected $isValid;

	/**
	 * @since 0.1
	 *
	 * @var Error[]
	 */
	protected $errors = array();

	/**
	 * @since 0.1
	 *
	 * @return self
	 */
	public static function newSuccess() {
		return new static( true );
	}

	/**
	 * @since 0.1
	 *
	 * @param Error[] $errors
	 *
	 * @return self
	 */
	public static function newError( array $errors ) {
		return new static( false, $errors );
	}

	/**
	 * Returns a result that represents the combination of the two given results.
	 * In particular, this means:
	 *
	 * If $a->getErrors() is empty and $a->isValid() is true, $b is returned.
	 * If $b->getErrors() is empty and $b->isValid() is true, $a is returned.
	 *
	 * Otherwise, a new Result is constructed that contains
	 * all errors from $a and $b, and is considered valid
	 * if both $a and $b were valid.
	 *
	 * @since 0.1
	 *
	 * @param self $a
	 * @param self $b
	 *
	 * @return self
	 */
	public static function merge( self $a, self $b ) {
		$aErrors = $a->getErrors();
		$bErrors = $b->getErrors();

		if ( $a->isValid() && empty( $aErrors ) ) {
			return $b;
		} elseif( $b->isValid() && empty( $bErrors ) ) {
			return $a;
		} else {
			$errors = array_merge( $aErrors, $bErrors );
			$valid = ( $a->isValid() && $b->isValid() );

			return new self( $valid, $errors );
		}
	}

	/**
	 * @since 0.1
	 *
	 * @param bool $isValid
	 * @param Error[] $errors
	 */
	protected function __construct( $isValid, array $errors = array() ) {
		$this->isValid = $isValid;
		$this->errors = $errors;
	}

	/**
	 * Returns if the value was found to be valid or not.
	 *
	 * @since 0.1
	 *
	 * @return bool
	 */
	public function isValid() {
		return $this->isValid;
	}

	/**
	 * Returns an array with the errors that occurred during validation.
	 *
	 * @since 0.1
	 *
	 * @return Error[]
	 */
	public function getErrors() {
		return $this->errors;
	}

}
