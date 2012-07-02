<?php
/**
 * Base class for record transformers. Record transformers know about the structure
 * of replies or query results from data sources, and implement a way to turn
 * these results into flat arrays that can be handed to a template for formatting.
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
 */
abstract class RecordTransformer {
	static function splitList( $s, $chars = ',;|' ) {
		if ( $s === null || $s === false ) {
			return $s;
		}

		if ( !is_string( $s ) ) {
			return $s;
		}

		$list = preg_split( '!\s*[' . $chars . ']\s*!', $s );

		return $list;
	}

	/**
	 * Initializes the TrecordTransformer from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		wfDebugLog( 'DataTransclusion', "constructing " . get_class( $this ) . "\n" );
	}

	/**
	* Implementations must return a flat associative array of key/value pairs, ready to be
	* handed to a template for formatting. The values are usually but not neccessarily
	* derived from the $record parameter in some way.
	* @param $raw_record raw data record, as returned by extractRecord(). May have any type,
	* 		but will frequenty consists of nested array or an XML DOM.
	*/
	abstract function transform( $raw_record );

	/**
	* Implementations should extract any error message contained in the response,
	* and return it as a string.
	* @param $response response as received from the data source (after decodeData())
	* @return the error message contained in $response, or null if there is none.
	*/
	abstract function extractError( $response );

	/**
	* Implementations should extract the actual data record from the response. This record
	* is later handed to transform() for further processing.
	* @param $response response as received from the data source (after decodeData())
	* @return raw data record, as returned by extractRecord(). May have any type,
	* 	but will frequenty consists of nested array or an XML DOM.
	*/
	abstract function extractRecord( $response );

	/**
	* Instantiates a new RecordTransformer, based on the $spec array. The field
	* $spec['class'] must contain the name of the class to instantiate. $spec
	* will be passed to the constructor of that class. It may contain further
	* options specific to that class.
	*/
	static function newRecordTransformer( $spec ) {
		$c = $spec[ 'class' ];
		$obj = new $c( $spec ); // pass spec array as constructor argument
		if ( !$obj ) {
			throw new MWException( "failed to instantiate $c." );
		}

		wfDebugLog( 'DataTransclusion', "created instance of $c\n" );
		$transformer = $obj;

		return $transformer;
	}

}

