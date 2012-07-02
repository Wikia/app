<?php
/**
 * Simple Record transformer for flattening nested arrays
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
 * Implementation of RecordTransformer that extracts individual field values from a complex nested
 * structure of arrays. 
 *
 * The following options are supported for the $spec array taken be the constructor:
 *
 *	 * $spec['fieldPathes']: an associative array giving a "path" for each fied which points
 *		to the actual field values inside the record, that is, the structure that 
 *		$spec['dataPath'] resolved to. Used by the transform() method.
 *	 * $spec['dataPath']: "path" to the actual data in the response structure, for use by 
 *		the extractRecord() method. The response data is assumed to consit of nested arrays. 
 *		Each entry in the path navigates one step in this structure. Each entry can be
 *		either a string (for a lookup in an associative array), and int (an index in a list),
 *		or a "meta-key" of the form @@N, where N is an integer. A meta-key refers to the
 *		Nth entry in an associative array: @1 would be "bar" in array( 'x' => "foo", 'y' => "bar" ).
 *		For more complex retrieval of the record, override extractRecord(). REQUIRED.
 *	 * $spec['errorPath']: "path" to error messages in the response structure, for use by the
 *		extractError() method. The path is evaluated as deswcribed for $spec['dataPath']. If an
 *		entry is found at the given position in the response structure, the request
 *		is assumed to have failed. For more complex detection of errors, override
 *		extractError(). If not given, the request is assumed to have been successful as long as 
 *		dataPath can be resolved to a data item.
*/
class FlattenRecord extends RecordTransformer {

	/**
	 * Initializes the FlattenRecord from the given parameter array. 
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		RecordTransformer::__construct( $spec );

		$this->fieldPathes = $spec['fieldPathes'];

		$this->dataPath = @$spec[ 'dataPath' ];
		$this->errorPath = @$spec[ 'errorPath' ];
	}

	/**
	 * Extracts values from the given $rec structure by resolving each path supplied to the constructor
	 * in $spec['fieldPathes'].
	 * 
	 * @param $rec a structured data record, as returned by extractRecord().
	 */
	public function transform( $rec ) {
		if ( !$rec ) return $rec;

		foreach ( $this->fieldPathes as $k => $path ) {
			$path = $this->fieldPathes[$k];
			$v = $this->resolvePath( $rec, $path );
			$v = $this->asString( $v ); 

			$r[ $k ] = $v; 
		}

		return $r;
	}

	/**
	 * Extracts any error message from the $data from the data source. This is done 
	 * by calling resolvePath() on the $spec['errorPath'] provided to the constructor.
	 * 
	 * @param $rec a structured data response, as received from the data source
	 */
	public function extractError( $data ) {
		$err = $this->resolvePath( $data, $this->errorPath );
		$err = $this->asString( $err );

		return $err;
	}

	/**
	 * Extracts the actual data record from the $data from the data source. This is done 
	 * by calling resolvePath() on the $spec['dataPath'] provided to the constructor.
	 * 
	 * @param $rec a structured data response, as received from the data source
	 */
	public function extractRecord( $data ) {
		$rec = $this->resolvePath( $data, $this->dataPath );

		return $rec;
	}

	/**
	 * Turns the given value into a string. Delegates to FlattenRecord::naiveAsString(),
	 * but may be overridden to change that.
	 */
	public function asString( $value ) {
		return FlattenRecord::naiveAsString( $value );
	}

	/**
	 * Resolvs the given path on the $data structure. Delegates to FlattenRecord::naiveResolvePath(),
	 * but may be overridden to change that.
	 */
	public function resolvePath( $data, $path, $split = true ) {
		return FlattenRecord::naiveResolvePath( $data, $path, $split );
	}

	public static function naiveAsString( $value ) {
		return "$value"; //XXX: will often fail. we could just throw here for non-primitives?
	}

	public static function naiveResolvePath( $data, $path, $split = true ) {
		if ( is_object( $data ) ) {
			if ( $dom instanceof DOMNode ) throw new MWException( "naiveResolvePath does not like DOMNode objects" );
			$data = wfObjectToArray( $data );
		}

		if ( !is_array( $data ) || $path === '.' ) {
			return $data; 
		}

		if ( $split && is_string( $path ) ) {
			$path = DataTransclusionSource::splitList( $path, '/' );
		}

		if ( is_string( $path ) || is_int( $path ) ) {
			return @$data[ $path ];
		}

		if ( !$path ) {
			return $data; 
		}

		$p = array_shift( $path );

		if ( is_string( $p ) && preg_match( '/^(@)?(\d+)$/', $p, $m ) ) { //numberic index
			$i = (int)$m[2];

			if ( $m[1] ) { //meta-index
				$k = array_keys( $data );
				$p = $k[ $i ];
			}
		} 

		if ( !isset( $data[ $p ] ) ) {
			return false;
		}

		$next = $data[ $p ];

		if ( $next && $path ) {
			return FlattenRecord::naiveResolvePath( $next, $path );
		} else {
			return $next;
		}

		//TODO: named components. separator??
	}

}

