<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

abstract class MobileFrontendTemplate {
	public $data;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->data = array();
	}

	/**
	 * Sets the value $value to $name
	 * @param $name
	 * @param $value
	 */
	public function set( $name, $value ) {
		$this->data[$name] = $value;
	}

	/**
	 * Sets the value $value to $name
	 * @param $name
	 * @param $value
	 */
	public function setByArray( $options ) {
		foreach ( $options as $name => $value ) {
			$this->set( $name, $value );
		}
	}

	/**
	 * Gets the value of $name
	 * @param $name
	 * @return string
	 */
	public function get( $name ) {
		return $this->data[$name];
	}

	/**
	 * Main function, used by classes that subclass MobileFrontendTemplate
	 * to show the actual HTML output
	 */
	abstract public function getHTML();
}
