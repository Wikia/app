<?php
/**
 * DataTransclusion Source implementation
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
  Implementations of DataTransclusionSource, fetching data records from an SQL database.
 *
 * In addition to the options supported by the DataTransclusionSource base class,
 * DBDataTransclusionSource accepts some additional options
 *
 *	 * $spec['query']: the SQL query for fetching records. May not contain a
 *		GROUP or LIMIT clause (use $spec['querySuffix'] for that). The
 *		WHERE clause is automatically generated from the requested key/value pair.
 *		If $spec['query'] already contains a WHERE clause, the condition for
 *		the desired key/value pair is appended using AND. Note that subqueries are
 *		not supported reliably. REQUIRED.
 *	 * $spec['querySuffix']: additional clauses to be added after the WHERE clause.
 *		Useful mostly to specify GROUP BY (or ORDER BY or LIMIT).
 *	 * $spec['fieldInfo']: like for DataTransclusionSource; Some additional hints are
 *		supported for each field:
 *	     * $spec['fieldInfo'][...]['dbfield']: the field's name in the database table, 
 *		if different from the logical name.
 *	     * $spec['fieldInfo'][...]['serialized']: format if the field contains a 
 *		serialized structure as a blob. If deserialzation yields an array, it is
 *		merged with the data record. Supported formats are 'json', 'wddx' and 
 * 		'php' for php serialized objects. 
 *
 * For more information on options supported by DataTransclusionSource, see the class-level
 * documentation there.
 */
class DBDataTransclusionSource extends DataTransclusionSource {

	/**
	 * Initializes the DBDataTransclusionSource from the given parameter array.
	 * @param $spec associative array of options. See class-level documentation for details.
	 */
	function __construct( $spec ) {
		if ( !isset( $spec[ 'fieldNames' ] ) && isset( $spec[ 'fieldInfo' ] ) ) {
			$spec[ 'fieldNames' ] = array_keys( $spec[ 'fieldInfo' ] );
		}

		DataTransclusionSource::__construct( $spec );

		$this->query = $spec[ 'query' ];
		$this->querySuffix = @$spec[ 'querySuffix' ];
	}

	public function getQuery( $field, $value, $db = null ) {
		if ( !$db ) {
			$db = wfGetDB( DB_SLAVE );
		}

		if ( !preg_match( '/^\w+[\w\d]+$/', $field ) ) {
			return false; // redundant, but make extra sure we don't get anythign evil here 
		}

		if ( !empty( $this->fieldInfo ) && isset( $this->fieldInfo[$field]['dbfield'] ) ) {
			$field = $this->fieldInfo[$field]['dbfield'];
		}

		if ( is_string( $value ) ) {
			$v = $db->addQuotes( $value ); 
		} else {
			$v = $value;
		}

		$where = "( " . $field . " = " . $v . " )";

		if ( preg_match( '/[)\s]WHERE[\s(]/is', $this->query ) ) {
			$sql = $this->query . " AND " . $where;
		} else {
			$sql = $this->query . " WHERE " . $where;
		}


		if ( $this->querySuffix ) {
			$sql = $sql . ' ' . $this->querySuffix;
		}

		return $sql;
	}

	public function fetchRawRecord( $field, $value, $options = null ) {
		$db = wfGetDB( DB_SLAVE );

		$sql = $this->getQuery( $field, $value, $db );
		wfDebugLog( 'DataTransclusion', "sql query for $field=$value: $sql\n" );

		$rs = $db->query( $sql, "DBDataTransclusionSource(" . $this->getName() . ")::fetchRecord" );

		if ( !$rs ) {
			wfDebugLog( 'DataTransclusion', "sql query failed for $field=$value\n" );
			return false;
		}

		$rec = $db->fetchRow( $rs );
		if ( !$rec ) {
			wfDebugLog( 'DataTransclusion', "no record found matching $field=$value\n" );
			return false;
		}

		$db->freeResult( $rs );

		foreach ( $rec as $k => $v ) { 
			if ( is_int( $k ) ) { # remove numeric keys, keep only assoc.
				unset( $rec[ $k ] );
			}
		}

		foreach ( $rec as $k => $v ) { 
			if ( isset( $this->fieldInfo[ $k ] ) ) {
				$format = null; # auto format
				$serialized = !empty( $this->fieldInfo[ $k ]['serialized'] );

				if ( $serialized && is_string( $this->fieldInfo[ $k ]['serialized'] ) ) {
					$format = $this->fieldInfo[ $k ]['serialized']; # serialization format, else use ['type']
				}
  
				$data = $this->convert( $k , $rec[ $k ], $format ); # unserialize or convert

				if ( $serialized && is_array( $data ) ) { # flatten serialized
					# flatten
					unset( $rec[ $k ] );

					foreach ( $data as $m => $w ) { # don't use array_merge, it stinks.
						$rec[ $m ] = $w;
					}
				} else {
					$rec[ $k ] = $data;
				}
			}
		}

		wfDebugLog( 'DataTransclusion', "loaded record for $field=$value from database\n" );
		return $rec;
	}
}
