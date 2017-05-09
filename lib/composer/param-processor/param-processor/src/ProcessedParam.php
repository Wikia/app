<?php

namespace ParamProcessor;

/**
 * Object representing a parameter that has been processed.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ProcessedParam {

	/**
	 * @since 1.0
	 *
	 * @var mixed
	 */
	private $value;

	/**
	 * @since 1.0
	 *
	 * @var string
	 */
	private $name;

	/**
	 * @since 1.0
	 *
	 * @var bool
	 */
	private $wasSetToDefault;

	/**
	 * @since 1.0
	 *
	 * @var null|mixed
	 */
	private $originalValue = null;

	/**
	 * @since 1.0
	 *
	 * @var null|string
	 */
	private $originalName = null;

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param boolean $wasSetToDefault
	 * @param string|null $originalName
	 * @param mixed $originalValue
	 */
	public function __construct( $name, $value, $wasSetToDefault, $originalName = null, $originalValue = null ) {
		$this->name = $name;
		$this->value = $value;
		$this->wasSetToDefault = $wasSetToDefault;
		$this->originalName = $originalName;
		$this->originalValue = $originalValue;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $originalName
	 */
	public function setOriginalName( $originalName ) {
		$this->originalName = $originalName;
	}

	/**
	 * @since 1.0
	 *
	 * @param mixed $originalValue
	 */
	public function setOriginalValue( $originalValue ) {
		$this->originalValue = $originalValue;
	}

	/**
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function wasSetToDefault() {
		return $this->wasSetToDefault;
	}

	/**
	 * @since 1.0
	 *
	 * @return null|mixed
	 */
	public function getOriginalValue() {
		return $this->originalValue;
	}

	/**
	 * @since 1.0
	 *
	 * @return null|string
	 */
	public function getOriginalName() {
		return $this->originalName;
	}

}
