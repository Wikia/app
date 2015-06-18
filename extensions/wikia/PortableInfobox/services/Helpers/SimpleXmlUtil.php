<?php

namespace Wikia\PortableInfobox\Helpers;

class SimpleXmlUtil {
	private static $instance = null;

	private function __construct() {
	}

	/**
	 * @return null|SimpleXmlUtil
	 */
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Gets contents of SimpleXML node as XML string
	 * Will return empty string for a non-node argument
	 *
	 * @param $node
	 *
	 * @return string
	 */
	public function getInnerXML( $node ) {
		$innerXML = '';
		// check for empty nodes, strlen used for "0" strings match
		if ( $node instanceof \SimpleXMLElement && ( strlen( (string)$node ) || $node->count() ) ) {
			$domElement = dom_import_simplexml( $node );

			if ( ( $domElement instanceof \DOMElement ) && ( $domElement->hasChildNodes() ) ) {
				foreach ( $domElement->childNodes as $child ) {
					$innerXML .= $child->ownerDocument->saveXML( $child );
				}
			}
		}

		return $innerXML;
	}
}
