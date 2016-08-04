<?php

namespace ParamProcessor;

/**
 * Object for holding options affecting the behavior of a ParamProcessor object.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Options {

	private $name;

	// During setup
	private $unknownInvalid = true;
	private $lowercaseNames = true;
	private $trimNames = true;
	private $acceptOverriding = true;

	// During clean
	private $trimValues = true;
	private $lowercaseValues = false;

	// During validation
	private $rawStringInputs = true;

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $unknownInvalid
	 */
	public function setUnknownInvalid( $unknownInvalid ) {
		$this->unknownInvalid = $unknownInvalid;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $lowercase
	 */
	public function setLowercaseNames( $lowercase ) {
		$this->lowercaseNames = $lowercase;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $rawInputs
	 */
	public function setRawStringInputs( $rawInputs ) {
		$this->rawStringInputs = $rawInputs;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $trim
	 */
	public function setTrimNames( $trim ) {
		$this->trimNames = $trim;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $trim
	 */
	public function setTrimValues( $trim ) {
		$this->trimValues = $trim;
	}

	/**
	 * @since 1.0
	 *
	 * @param boolean $lowercase
	 */
	public function setLowercaseValues( $lowercase ) {
		$this->lowercaseValues = $lowercase;
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
	 * @return boolean
	 */
	public function unknownIsInvalid() {
		return $this->unknownInvalid;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function lowercaseNames() {
		return $this->lowercaseNames;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isStringlyTyped() {
		return $this->rawStringInputs;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function trimNames() {
		return $this->trimNames;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function trimValues() {
		return $this->trimValues;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function lowercaseValues() {
		return $this->lowercaseValues;
	}

	/**
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function acceptOverriding() {
		return $this->acceptOverriding;
	}

}
