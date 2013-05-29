<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 15:01
 */

/**
 * Class JsonFormatNode
 *
 * Json representation node
 */
abstract class JsonFormatNode {
	/**
	 * @return string
	 */
	public function getType() {
		$matches = array();
		if ( preg_match( "/JsonFormat(\\w+)Node/", get_class($this), $matches ) ) {
			return lcfirst( $matches[1] );
		}
		return get_class( $this );
	}


	public abstract function toArray();
}
