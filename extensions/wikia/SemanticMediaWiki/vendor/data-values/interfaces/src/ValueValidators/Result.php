<?php

namespace ValueValidators;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
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
	 * @return Result
	 */
	public static function newSuccess() {
		return new static( true );
	}

	/**
	 * @since 0.1
	 *
	 * @param Error[] $errors
	 *
	 * @return Result
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
	 * @param Result $a
	 * @param Result $b
	 *
	 * @return Result
	 */
	public static function merge( Result $a, Result $b ) {
		$aErrors = $a->getErrors();
		$bErrors = $b->getErrors();

		if ( $a->isValid() && empty( $aErrors ) ) {
			return $b;
		} elseif( $b->isValid() && empty( $bErrors ) ) {
			return $a;
		} else {
			$errors = array_merge( $aErrors, $bErrors );
			$valid = ( $a->isValid() && $b->isValid() );

			return new Result( $valid, $errors );
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

/**
 * @deprecated
 */
class ResultObject extends Result {}
