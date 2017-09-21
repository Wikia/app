<?php


class WallBuilderGenericException extends Exception {
	/** @var array $context */
	private $context = [];

	/**
	 * WallBuilderException constructor.
	 * @param string $message error message
	 * @param array $context data array which can be output for logging
	 */
	public function __construct( $message = "", array $context = [] ) {
		parent::__construct( $message );
		$this->context = $context;

		// return self for traceback
		$this->context['exception'] = $this;
	}

	/**
	 * Get context for error logging
	 * @return array
	 */
	public function getContext(): array {
		return $this->context;
	}
}
