<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * An enum class.
 */
abstract class WCEnum /* extends SplEnum {PHP 5.3} */ {

	/**
	 * Default value if none is specified.
	 */
	const __default = 0;


	/**
	 * An integer key.
	 * @var integer
	 */
	public $key;


	/**
	 * Constructor.
	 * Takes a unique integer key, which should be defined as a class constant.
	 * @param integer $key
	 */
	public function __construct( $key = self::__default ) {
		$this->key = $key;
	}


	/**
	 * The string value, unless overridden, is the name of the constant.
	 * @return string
	 */
	public function __toString() {
		$object = new ReflectionClass( $this );
		return array_search( $this->key, $object->getConstants() );
	}
}
