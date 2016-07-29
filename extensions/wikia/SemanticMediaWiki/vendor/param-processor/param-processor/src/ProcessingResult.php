<?php

namespace ParamProcessor;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ProcessingResult {

	/**
	 * @var ProcessedParam[]
	 */
	protected $parameters;

	/**
	 * @var ProcessingError[]
	 */
	protected $errors;

	/**
	 * @param ProcessedParam[] $parameters
	 * @param ProcessingError[] $errors
	 */
	public function __construct( array $parameters, array $errors = array() ) {
		$this->parameters = $parameters;
		$this->errors = $errors;
	}

	/**
	 * @return ProcessedParam[]
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * @return ProcessingError[]
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @since 1.0.1
	 * @return bool
	 */
	public function hasFatal() {
		foreach ( $this->errors as $error ) {
			if ( $error->isFatal() ) {
				return true;
			}
		}

		return false;
	}

}
