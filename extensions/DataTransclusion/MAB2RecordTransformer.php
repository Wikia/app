<?php
/**
 * Record transformer for MAB2 records as specified by http://www.d-nb.de/standardisierung/txt/titelmab.txt
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

global $mab_field_map; # auto-loaded from within a function, so top scope is not global!
$mab_field_map = array(
    'title' => array( '081', '200b', '304', '310', '331', '335' ),
    'series' => array( '089', '090', '451', '545' ),
    'edition' => array( '400', '403' ),
    'volume' => array( '455', '456' ),
    'author' => array( ), # added later
    'editor' => array( ), # added later
    'institution' => array( '200', '204',  ),
    'language' => array( '037', '037a', '037b', '037c', '037z' ),
    'annote' => array( '334', '434', '501' ),
    'note' => array( '359' ),
    'journal' => array( '376' ),
    'address' => array( '410', '415' ),
    'publisher' => array( '412', '417' ),
    'date' => array( '425' ),
    'pages' => array( '433' ),
    'type' => array( '509' ),
    'copyright' => array( '531' ),
    'isbn' => array( '540', '540a', '540b' ),
    'issn' => array( '542', ),
    'lcc' => array( '544', '25l' ),
    'doi' => array( '552', ),
    'dnb' => array( '025a', ),
    'zdb' => array( '025z', ),
    'zka' => array( '025g', ),
    'hbz' => array( '025h', ),
    'id' => array( '001', ),
    'howpublished' => array( '590', '596', ),
);

for ($i = 0; $i<25; $i++) {
    $n = 100 + 4*$i;
    $mab_field_map['author'][] = "{$n}";
    $mab_field_map['author'][] = "{$n}a";
    $mab_field_map['author'][] = "{$n}e";
    $mab_field_map['editor'][] = "{$n}b";
    $mab_field_map['editor'][] = "{$n}c";
}

$mab_field_map['author'][] = '333';
$mab_field_map['author'][] = '359';
$mab_field_map['author'][] = '369';

/**
 * Implementations of RecordTransformer for processing data from the OpenLibrary web API.
 * No configuration options are needed.
 */
class MAB2RecordTransformer extends RecordTransformer {

	/**
	 * Initializes the RecordTransformer from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		RecordTransformer::__construct( $spec );

		$this->dataPath = @$spec[ 'dataPath' ];
		$this->errorPath = @$spec[ 'errorPath' ];
		$this->fieldPrefix = @$spec[ 'fieldPrefix' ];
	}

	public static function getMABFields( $logical ) {
		global $mab_field_map;

		if ( isset( $mab_field_map[ $logical ] ) ) {
			return $mab_field_map[ $logical ];
		} else {
			return false;
		}
	}

	public function transform( $rec ) {
		global $mab_field_map;

		$r = array();

		foreach ( $mab_field_map as $field => $items ) {
		    foreach ( $items as $item ) {
			if ( $this->fieldPrefix ) $item = fieldPrefix + $item;

			if ( !empty( $rec[ $item ] ) ) {
			    if ( is_array( $rec[ $item ] ) ) {
				if ( empty( $r[ $field ] ) ) {
				    $r[ $field ] = $rec[ $item ];
				} else {
				    $r[ $field ] = array_merge( $r[ $field ], $rec[ $item ] );
				}
			    } else {
				$r[ $field ][] = $rec[ $item ];
			    }

			    break;
			}
		    }
		}

		foreach ($r as $f => $values) {
		    if ( count($values) == 0 ) unset( $r[ $f ] );
		    elseif ( count($values) == 1 ) $r[ $f ] = MAB2RecordTransformer::mangleValue( $values[0] );
		    else {
			$values = array_unique( $values );
			$values = array_map( array('MAB2RecordTransformer', 'mangleValue'), $values );
			$r[ $f ] = join(', ', $values);
		    }
		}

		return $r;
	}

	function mangleValue( $v ) {
		$v = preg_replace( '/<<\[(.*?)\]>>/', '', $v );
		$v = preg_replace( '/\[(.*?)\]/', '$1', $v );
		$v = preg_replace( '/<<(.*?)>>/', '$1', $v );
		$v = preg_replace( '/<(.*?)>/', '$1', $v );
		$v = preg_replace( '/^[¤¬]/', '', $v );
		return $v;
	}

	/**
	 * Extracts any error message from the $data from the data source. This is done
	 * by calling resolvePath() on the $spec['errorPath'] provided to the constructor.
	 *
	 * @param $rec a structured data response, as received from the data source
	 */
	public function extractError( $data ) {
		if ( !$this->dataPath ) {
			$r = $this->extractRecord( $data );

			if ( $r ) return false;
			else return true;
		}

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
		if ( !$this->dataPath ) {
			return $data;
		}

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

}

