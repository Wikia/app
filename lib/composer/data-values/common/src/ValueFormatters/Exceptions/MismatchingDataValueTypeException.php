<?php

namespace ValueFormatters\Exceptions;

use Exception;
use ValueFormatters\FormattingException;

/**
 * @since 0.2.1
 *
 * @licence GNU GPL v2+
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class MismatchingDataValueTypeException extends FormattingException {

	/**
	 * @var string
	 */
	private $expectedValueType;

	/**
	 * @var string
	 */
	private $dataValueType;

	/**
	 * @param string $expectedValueType
	 * @param string $dataValueType
	 * @param string $message
	 * @param Exception $previous
	 */
	public function __construct( $expectedValueType, $dataValueType, $message = '',
		Exception $previous = null
	) {
		$this->expectedValueType = $expectedValueType;
		$this->dataValueType = $dataValueType;

		$message = '$dataValueType "' . $dataValueType . '" does not match $expectedValueType "'
			. $expectedValueType . '": $message';

		parent::__construct( $message, 0, $previous );
	}

	/**
	 * @return string
	 */
	public function getExpectedValueType() {
		return $this->expectedValueType;
	}

	/**
	 * @return string
	 */
	public function getDataValueType() {
		return $this->dataValueType;
	}

}
