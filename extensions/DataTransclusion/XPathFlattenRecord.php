<?php
/**
 * Simple Record transformer for extracting strings from an XML DOM using XPath.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler for Wikimedia Deutschland
 * @copyright © 2010 Wikimedia Deutschland (Author: Daniel Kinzler)
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * Extension of FlattenRecord transformer that handles arbitrary XML using XPath.
 *
 * In addition to the options supported by the FlattenRecord class,
 * XPathFlattenRecord accepts some additional options, and changes the convention for others.
 *
 *	 * $spec['dataPath']: xpath to the actual data in the structure returned from the
 *		HTTP request. This uses standard W3C XPath syntax. REQUIRED.
 *	 * $spec['fieldPathes']: an associative array giving a XPath for each fied which points
 *		to the actual field values inside the record, that is, the structure that 
 *		$spec['dataPath'] resolved to. Useful when field values are returned as complex
 *		records. For more complex processing, override the method flattenRecord().
 *	 * $spec['errorPath']: xpath to error messages in the structure returned from the
 *		HTTP request. If an
 *		entry is found at the given position in the response structure, the request
 *		is assumed to have failed. For more complex detection of errors, override
 *		extractError(). If not given, the request is assumed to have been
 *		successful as long as dataPath can be resolved to a data item.
 *
 * For more information on options supported by FlattenRecord 
 * see the class-level documentation there.
 */
class XPathFlattenRecord extends FlattenRecord {

	/**
	 * Initializes the XPathFlattenRecord from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		FlattenRecord::__construct( $spec );
	}

	public function asString( $value ) {
		return XPathFlattenRecord::domAsString( $value );
	}

	public function resolvePath( $data, $path, $split = true ) {
		return XPathFlattenRecord::domResolvePath( $data, $path, $split );
	}

	public static function domResolvePath( $dom, $xpath ) {
		if ( !$dom ) return false;
		if ( ! is_object( $dom ) ) throw new MWException( "domResolvePath expects a DOMNode object" );
		if ( ! ( $dom instanceof DOMNode ) ) throw new MWException( "domResolvePath expects a DOMNode object" );

		$lookup = new DOMXPath( $dom->ownerDocument );

		$res = $lookup->query( $xpath, $dom );

		if ( $res instanceof DOMNodeList ) {
			if ( $res->length == 0 ) $res = null;
			else $res = $res->item( 0 );
		}

		return $res;
	}

	public static function domAsString( $v ) {
		if ( is_object($v) ) {
			if ( $v instanceof DOMNodeList ) {
				if ( $v->length ) $v = $v->item( 0 ); 
				else $v = null;
			}

			if ( $v instanceof DOMNamedNodeMap ) {
				$v = $v->item( 0 ); 
			}

			if ( $v instanceof DOMNode ) {
				$v = $v->textContent; 
			}
		}

		return "$v";
	}

}

